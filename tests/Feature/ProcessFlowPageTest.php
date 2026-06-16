<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ProcessFlowPageTest extends TestCase
{
    /**
     * La página de flujo del proceso debe renderizar e incluir
     * el módulo del diagrama y el markup que el JS necesita.
     */
    public function test_process_flow_page_renders_with_diagram_assets(): void
    {
        $user = User::where('email', 'like', '%@gptservices.com')->first();

        $this->assertNotNull($user, 'No hay usuarios con acceso al panel para probar.');

        $response = $this->actingAs($user)->get('/compras/process-flow');

        $response->assertOk();
        $response->assertSee('data-flow-root', false);
        $response->assertSee('flow-data-requisition', false);
        $response->assertSee('flow-data-order', false);
        // El nombre del asset varía entre modo hot (resources/js/flow-diagram.js)
        // y modo manifest (flow-diagram-HASH.js), por eso se busca sin extensión.
        $response->assertSee('flow-diagram', false);
        $response->assertSee('progress-approval', false);
    }
}
