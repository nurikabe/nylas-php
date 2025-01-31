<?php

namespace Tests\Authentication;

use Tests\AbsCase;

/**
 * ----------------------------------------------------------------------------------
 * Hosted Test
 * ----------------------------------------------------------------------------------
 *
 * @link https://developer.nylas.com/docs/api/#tag--Hosted-Authentication
 * @author lanlin
 * @change 2021/07/20
 *
 * @internal
 */
class HostedTest extends AbsCase
{
    // ------------------------------------------------------------------------------

    public function testGetOAuthAuthorize(): void
    {
        $params =
         [
             'state'         => 'testing',
             'scopes'        => 'email,contacts,calendar',
             'login_hint'    => $this->faker->email,
             'redirect_uri'  => $this->faker->url,
             'response_type' => 'code',
         ];

        $data = $this->client->Authentication->Hosted->getOAuthAuthorizeUrl($params);

        $this->assertTrue(\is_string($data));
    }

    // ------------------------------------------------------------------------------

    public function testPostOAuthToken(): void
    {
        $code = $this->faker->postcode;

        $this->mockResponse([
            'client_id'      => $this->faker->uuid,
            'client_secret'  => $this->faker->email,
            'grant_type'     => 'authorization_code',
            'code'           => $this->faker->postcode,
        ]);

        $data = $this->client->Authentication->Hosted->postOAuthToken($code);

        $this->assertTrue(!empty($data['client_id']));
    }

    // ------------------------------------------------------------------------------

    public function testPostOAuthRevoke(): void
    {
        $this->mockResponse(['success' => 'true']);

        $data = $this->client->Authentication->Hosted->postOAuthRevoke();

        $this->assertTrue(!empty($data['success']));
    }

    // ------------------------------------------------------------------------------
}
