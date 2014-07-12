<?php
namespace Audeio\Spotify\Oauth2\Client\Provider;

use League\OAuth2\Client\Provider\IdentityProvider;
use League\OAuth2\Client\Provider\User;
use League\OAuth2\Client\Token\AccessToken;

class Spotify extends IdentityProvider
{

    public function urlAuthorize()
    {
        return 'https://accounts.spotify.com/authorize';
    }

    public function urlAccessToken()
    {
        return 'https://accounts.spotify.com/api/token';
    }

    public function urlUserDetails(AccessToken $token)
    {
        $this->headers = array(
            'Authorization' => sprintf('Bearer %s', $token->accessToken)
        );

        return 'https://api.spotify.com/v1/me';
    }

    public function userDetails($response, AccessToken $token)
    {
        $this->headers = array(
            'Authorization' => sprintf('Bearer %s', $token->accessToken)
        );

        $user = new User();
        $user->uid = $response['id'];
        $user->name = $response['display_name'];
        $user->email = $response['email'];
        $user->imageUrl = isset($response['images'][0]['url']) ?: null;
        $user->urls = $response['external_urls'];

        return $user;
    }
}