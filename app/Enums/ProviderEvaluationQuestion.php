<?php

namespace App\Enums;

enum ProviderEvaluationQuestion: string
{
    // ── Proveeduría ──────────────────────────────────────────────────────────
    case CumplimientoRequisitos = 'cumplimiento_requisitos';
    case CalidadProducto = 'calidad_producto';
    case Negociacion = 'negociacion';
    case TiempoEntrega = 'tiempo_entrega';
    case CumplimientoHse = 'cumplimiento_hse';
    case ServicioCliente = 'servicio_cliente';

    // ── Servicio — Solicitante (Siempre / Regularmente / Pocas Veces / Nunca)
    case SrvCumplimientoEspecificaciones = 'srv_cumplimiento_especificaciones';
    case SrvJornadaLaboral = 'srv_jornada_laboral';
    case SrvDocumentacionRequerida = 'srv_documentacion_requerida';
    case SrvEpp = 'srv_epp';
    case SrvResiduos = 'srv_residuos';
    case SrvApoyoActividades = 'srv_apoyo_actividades';
    case SrvHerramientas = 'srv_herramientas';
    case SrvReportes = 'srv_reportes';
    case SrvInquietudes = 'srv_inquietudes';
    case SrvTiempoRespuesta = 'srv_tiempo_respuesta';

    // ── Servicio — Comprador (Sí / No) ───────────────────────────────────────
    case SrvFianzas = 'srv_fianzas';
    case SrvInformes = 'srv_informes';
    case SrvFacturas = 'srv_facturas';
    case SrvReclamaciones = 'srv_reclamaciones';
    case SrvCondicionesPago = 'srv_condiciones_pago';
    case SrvPreciosCompetitivos = 'srv_precios_competitivos';
    case SrvFechasOc = 'srv_fechas_oc';
    case SrvEstatus = 'srv_estatus';
    case SrvCanalesAtencion = 'srv_canales_atencion';
    case SrvDocumentacionPrevia = 'srv_documentacion_previa';

    /** Human-readable label shown in the evaluation form / infolist. */
    public function label(): string
    {
        return match ($this) {
            // proveeduria
            self::CumplimientoRequisitos => 'Cumplimiento de requisitos y especificaciones',
            self::CalidadProducto => 'Calidad del producto o servicio',
            self::Negociacion => 'Negociación (precio, condiciones de pago)',
            self::TiempoEntrega => 'Tiempo de entrega',
            self::CumplimientoHse => 'Cumplimiento de HSE (si aplica)',
            self::ServicioCliente => 'Servicio al cliente (comunicación y atención)',
            // servicio — solicitante
            self::SrvCumplimientoEspecificaciones => '¿El servicio prestado cumplió con todas las especificaciones y/o normas técnicas establecidas en la requisición?',
            self::SrvJornadaLaboral => '¿El contratista cumple con su jornada laboral contratada en sitio en tiempo y forma?',
            self::SrvDocumentacionRequerida => '¿Se presenta la documentación requerida? (DC3, Bitácoras, Certificados, etc.)',
            self::SrvEpp => '¿El personal empleado por el contratista usa y mantiene el EPP requeridos por y durante la actividad?',
            self::SrvResiduos => '¿Recolecta y se hace cargo de sus residuos?',
            self::SrvApoyoActividades => '¿Durante su presencia en sitio apoya con las actividades asignadas por el ingeniero de campo?',
            self::SrvHerramientas => '¿Las herramientas y equipo que utiliza su personal NO son reacondicionadas y/o adaptadas?',
            self::SrvReportes => '¿El contratista entrega reportes y/o bitácoras en tiempo y forma de acuerdo a lo solicitado?',
            self::SrvInquietudes => '¿Se transmiten todas las inquietudes del cliente al personal de GPT que se encuentra en sitio y no se toman decisiones unilateralmente?',
            self::SrvTiempoRespuesta => '¿Su tiempo de respuesta ante problemas/conflictos que se presentaron en sitio es oportuno?',
            // servicio — comprador
            self::SrvFianzas => 'Aplica u otorga fianzas antes, durante y después del servicio',
            self::SrvInformes => 'Los informes presentados por el contratista son claros, cumplen con firmas del personal autorizado en campo y tienen el soporte requerido',
            self::SrvFacturas => 'Todas las facturas y sus soportes requeridos durante la ejecución fueron entregados de acuerdo a lo programado y sin errores',
            self::SrvReclamaciones => 'Atiende los reclamos y consultas que se presentaron durante la ejecución y/o después de las actividades realizadas en sitio',
            self::SrvCondicionesPago => 'Ofrece condiciones de pago flexibles',
            self::SrvPreciosCompetitivos => 'Tiene la capacidad de satisfacer y presentar precios competitivos antes y después del servicio solicitado',
            self::SrvFechasOc => 'Cumple con las fechas establecidas dentro de la orden de compra ya confirmada para la ejecución del servicio',
            self::SrvEstatus => 'Continuamente se reporta el estatus de la compra al área',
            self::SrvCanalesAtencion => 'Los canales de atención por parte del proveedor son adecuados previamente, durante y después del servicio',
            self::SrvDocumentacionPrevia => 'Presenta toda la documentación que aplica al servicio que se solicita previamente a su contratación',
        };
    }

    /** The respondent role responsible for answering this question. */
    public function role(): string
    {
        return match ($this) {
            self::CumplimientoRequisitos,
            self::CalidadProducto,
            self::SrvCumplimientoEspecificaciones,
            self::SrvJornadaLaboral,
            self::SrvDocumentacionRequerida,
            self::SrvEpp,
            self::SrvResiduos,
            self::SrvApoyoActividades,
            self::SrvHerramientas,
            self::SrvReportes,
            self::SrvInquietudes,
            self::SrvTiempoRespuesta => 'solicitante',

            self::Negociacion,
            self::TiempoEntrega,
            self::ServicioCliente,
            self::SrvFianzas,
            self::SrvInformes,
            self::SrvFacturas,
            self::SrvReclamaciones,
            self::SrvCondicionesPago,
            self::SrvPreciosCompetitivos,
            self::SrvFechasOc,
            self::SrvEstatus,
            self::SrvCanalesAtencion,
            self::SrvDocumentacionPrevia => 'comprador',

            self::CumplimientoHse => 'almacen',
        };
    }

    /** Order category this question belongs to. */
    public function orderType(): string
    {
        return match ($this) {
            self::CumplimientoRequisitos,
            self::CalidadProducto,
            self::Negociacion,
            self::TiempoEntrega,
            self::CumplimientoHse,
            self::ServicioCliente => 'proveeduria',

            default => 'servicio',
        };
    }

    /**
     * Options for the form — labels only, no scores visible to users.
     *
     * @return array<string, string>
     */
    public function formOptions(): array
    {
        return match ($this) {
            // proveeduria
            self::CumplimientoRequisitos => [
                'cumple_completamente' => 'Cumple completamente',
                'cumple_parcialmente' => 'Cumple parcialmente',
                'no_cumple' => 'No cumple',
            ],
            self::CalidadProducto => [
                'excelente' => 'Excelente',
                'buena' => 'Buena',
                'aceptable' => 'Aceptable',
                'deficiente' => 'Deficiente',
            ],
            self::Negociacion => [
                'muy_favorable' => 'Muy favorable',
                'aceptable' => 'Aceptable',
                'negociacion_dificil' => 'Negociación difícil',
            ],
            self::TiempoEntrega => [
                'a_tiempo' => 'A tiempo',
                'retraso_menor' => 'Retraso menor (1-2 días)',
                'retraso_significativo' => 'Retraso significativo',
            ],
            self::CumplimientoHse => [
                'cumple_todos' => 'Cumple con todos los requisitos',
                'cumple_parcialmente' => 'Cumple parcialmente',
                'no_cumple' => 'No cumple',
            ],
            self::ServicioCliente => [
                'excelente' => 'Excelente',
                'aceptable' => 'Aceptable',
                'deficiente' => 'Deficiente',
            ],
            // servicio — solicitante (Siempre / Regularmente / Pocas Veces / Nunca)
            self::SrvCumplimientoEspecificaciones,
            self::SrvJornadaLaboral,
            self::SrvDocumentacionRequerida,
            self::SrvEpp,
            self::SrvResiduos,
            self::SrvApoyoActividades,
            self::SrvHerramientas,
            self::SrvReportes,
            self::SrvInquietudes,
            self::SrvTiempoRespuesta => [
                'siempre' => 'Siempre',
                'regularmente' => 'Regularmente',
                'pocas_veces' => 'Pocas Veces',
                'nunca' => 'Nunca',
            ],
            // servicio — comprador (Sí / No)
            self::SrvFianzas,
            self::SrvInformes,
            self::SrvFacturas,
            self::SrvReclamaciones,
            self::SrvCondicionesPago,
            self::SrvPreciosCompetitivos,
            self::SrvFechasOc,
            self::SrvEstatus,
            self::SrvCanalesAtencion,
            self::SrvDocumentacionPrevia => [
                'si' => 'Sí',
                'no' => 'No',
            ],
        };
    }

    /**
     * Returns the hidden score for a given option key.
     */
    public function scoreForOption(string $option): int
    {
        return $this->scores()[$option] ?? 0;
    }

    /**
     * @return array<string, int>
     */
    private function scores(): array
    {
        return match ($this) {
            // proveeduria
            self::CumplimientoRequisitos => [
                'cumple_completamente' => 10,
                'cumple_parcialmente' => 8,
                'no_cumple' => 0,
            ],
            self::CalidadProducto => [
                'excelente' => 10,
                'buena' => 8,
                'aceptable' => 6,
                'deficiente' => 0,
            ],
            self::Negociacion => [
                'muy_favorable' => 10,
                'aceptable' => 8,
                'negociacion_dificil' => 6,
            ],
            self::TiempoEntrega => [
                'a_tiempo' => 10,
                'retraso_menor' => 6,
                'retraso_significativo' => 0,
            ],
            self::CumplimientoHse => [
                'cumple_todos' => 10,
                'cumple_parcialmente' => 7,
                'no_cumple' => 0,
            ],
            self::ServicioCliente => [
                'excelente' => 10,
                'aceptable' => 8,
                'deficiente' => 0,
            ],
            // servicio — solicitante
            self::SrvCumplimientoEspecificaciones,
            self::SrvJornadaLaboral,
            self::SrvDocumentacionRequerida,
            self::SrvEpp,
            self::SrvResiduos,
            self::SrvApoyoActividades,
            self::SrvHerramientas,
            self::SrvReportes,
            self::SrvInquietudes,
            self::SrvTiempoRespuesta => [
                'siempre' => 10,
                'regularmente' => 7,
                'pocas_veces' => 5,
                'nunca' => 0,
            ],
            // servicio — comprador
            self::SrvFianzas,
            self::SrvInformes,
            self::SrvFacturas,
            self::SrvReclamaciones,
            self::SrvCondicionesPago,
            self::SrvPreciosCompetitivos,
            self::SrvFechasOc,
            self::SrvEstatus,
            self::SrvCanalesAtencion,
            self::SrvDocumentacionPrevia => [
                'si' => 10,
                'no' => 0,
            ],
        };
    }

    /** @return self[] */
    public static function forRole(string $role): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->role() === $role));
    }

    /** @return self[] */
    public static function forType(string $type): array
    {
        return array_values(array_filter(self::cases(), fn ($case) => $case->orderType() === $type));
    }
}
