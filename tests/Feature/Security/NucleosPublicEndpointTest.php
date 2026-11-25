<?php

namespace Tests\Feature\Security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesBikoData;
use Tests\TestCase;

/**
 * A rota pública /nucleo/estados/{estado} (usada no pré-cadastro)
 * não pode expor contato, endereço nem dados internos dos núcleos.
 */
class NucleosPublicEndpointTest extends TestCase
{
    use CreatesBikoData;
    use RefreshDatabase;

    public function test_returns_only_public_fields(): void
    {
        $this->createNucleo([
            'NomeNucleo' => 'Núcleo Teste',
            'Regiao' => 'Zona Sul',
            'InfoInscricao' => 'Inscrições abertas',
            'Telefone' => '11988887777',
            'Email' => 'contato@nucleo.test',
            'Endereco' => 'Rua Secreta',
        ]);

        $response = $this->getJson('/nucleo/estados/SP')->assertOk();

        $this->assertCount(1, $response->json());
        $this->assertEqualsCanonicalizing(
            ['id', 'InfoInscricao', 'NomeNucleo', 'Regiao'],
            array_keys($response->json()[0])
        );
        $response->assertDontSee('11988887777')
            ->assertDontSee('contato@nucleo.test')
            ->assertDontSee('Rua Secreta');
    }

    public function test_filters_by_state_and_hides_inactive(): void
    {
        $this->createNucleo(['NomeNucleo' => 'Ativo SP', 'Estado' => 'SP']);
        $this->createNucleo(['NomeNucleo' => 'Ativo RJ', 'Estado' => 'RJ']);
        $this->createNucleo(['NomeNucleo' => 'Inativo SP', 'Estado' => 'SP', 'Status' => 0]);

        $this->getJson('/nucleo/estados/SP')->assertOk()->assertJsonCount(1)
            ->assertJsonPath('0.NomeNucleo', 'Ativo SP');
        $this->getJson('/nucleo/estados/all')->assertOk()->assertJsonCount(2);
    }

    public function test_rejects_invalid_state_parameter(): void
    {
        $this->get('/nucleo/estados/xpto')->assertNotFound();
    }
}
