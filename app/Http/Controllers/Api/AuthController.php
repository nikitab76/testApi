<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessTokenFactory;
use Laravel\Passport\Token;
use App\Models\User;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    // Авторизация — получение access_token
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('access_token')->accessToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ]);
    }

    // Отзыв access_token (logout)
    public function revokeToken(TokenRepository $tokens, $tokenId)
    {
        $token = $tokens->find($tokenId);

        if ($token->user_id !== auth()->id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $tokens->revokeAccessToken($tokenId);

        return response()->json(['message' => 'Token revoked']);
    }

    // Получить все активные токены пользователя
    public function tokens(TokenRepository $tokens)
    {
        return response()->json(
            $tokens->forUser(auth()->user())
        );
    }

    // Обновление токена (заглушка, т.к. в Laravel Passport refresh-token по умолчанию не используется через API)
    public function refresh()
    {
        return response()->json(['message' => 'Token refresh not implemented'], 501);
    }

    public function clients(ClientRepository $clients)
    {
        return response()->json(
            $clients->activeForUser(auth()->user()->id)
        );
    }
    public function storeClient(Request $request, ClientRepository $clients)
    {
        $request->validate([
            'name' => 'required|string',
            'redirect' => 'required|url',
        ]);

        $client = $clients->create(
            auth()->user()->id, $request->name, $request->redirect
        );

        return response()->json($client);
    }

    public function updateClient($clientId, Request $request, ClientRepository $clients)
    {
        $request->validate([
            'name' => 'string|nullable',
            'redirect' => 'url|nullable',
        ]);

        $client = $clients->find($clientId);

        if ($client->user_id !== auth()->id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $clients->update(
            $client,
            $request->name ?? $client->name,
            $request->redirect ?? $client->redirect
        );

        return response()->json(['message' => 'Client updated']);
    }

    public function destroyClient($clientId, ClientRepository $clients)
    {
        $client = $clients->find($clientId);

        if ($client->user_id !== auth()->id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $clients->delete($client);

        return response()->json(['message' => 'Client deleted']);
    }

    public function scopes()
    {
        return response()->json(Passport::scopes());
    }

    public function personalTokens(PersonalAccessTokenFactory $factory)
    {
        return response()->json(
            auth()->user()->tokens()->get()
        );
    }

    public function createPersonalToken(Request $request, PersonalAccessTokenFactory $factory)
    {
        $request->validate([
            'name' => 'required|string',
            'scopes' => 'array'
        ]);

        $token = $factory->make(
            auth()->user()->id,
            $request->name,
            $request->scopes ?? []
        );

        return response()->json(['access_token' => $token->accessToken]);
    }

    public function revokePersonalToken($tokenId)
    {
        $token = auth()->user()->tokens()->findOrFail($tokenId);
        $token->revoke();

        return response()->json(['message' => 'Personal access token revoked']);
    }
}

