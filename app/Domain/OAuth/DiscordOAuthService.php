<?php namespace Zeropingheroes\Lanager\Domain\OAuth;

use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Http\Uri\Uri;
use OAuth\Common\Http\Uri\UriInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\Common\Token\TokenInterface;
use OAuth\OAuth2\Token\StdOAuth2Token;
use OAuth\OAuth2\Service\AbstractService;
/**
 * Class DiscordOAuthService
 */
class DiscordOAuthService extends AbstractService
{
	const SCOPE_IDENTIFY 				= 'identify';
	const SCOPE_EMAIL					= 'email';
	const SCOPE_INVITE					= 'guilds.join';

    public function __construct(
        CredentialsInterface $credentials,
        ClientInterface $httpClient,
        TokenStorageInterface $storage,
        $scopes = array(''),
        UriInterface $baseApiUri = null
    ) {
        parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri);
        if (null === $baseApiUri) {
            $this->baseApiUri = new Uri('https://discordapp.com/api/');
        }
    }
    /**
     * Returns the authorization API endpoint.
     * @return UriInterface
     */
    public function getAuthorizationEndpoint()
    {
        return new Uri($this->baseApiUri . '/oauth2/authorize');
    }
    /**
     * Returns the access token API endpoint.
     * @return UriInterface
     */
    public function getAccessTokenEndpoint()
    {
        return new Uri($this->baseApiUri . '/oauth2/token');
    }
    /**
     * Parses the access token response and returns a TokenInterface.
     *
     * @param string $responseBody
     *
     * @return TokenInterface
     * @throws TokenResponseException
     */
    protected function parseAccessTokenResponse($responseBody)
	{
		$data = json_decode($responseBody, true);

        if (null === $data || !is_array($data)) {
            throw new TokenResponseException('Unable to parse response.');
        } elseif (isset($data['error'])) {
            throw new TokenResponseException('Error in retrieving token: "' . $data['error'] . '"');
        }
        $token = new StdOAuth2Token();
        $token->setAccessToken($data['access_token']);
        $token->setLifetime($data['expires_in']);
        if (isset($data['refresh_token'])) {
			$token->setRefreshToken($data['refresh_token']);
	        unset($data['refresh_token']);
        }
		unset($data['access_token']);
		unset($data['expires_in']);
		$token->setExtraParams($data);
		return $token;
    }
    /**
     * {@inheritdoc}
     */
    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_HEADER_BEARER;
    }
}
