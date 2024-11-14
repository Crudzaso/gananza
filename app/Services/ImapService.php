<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpImap\Mailbox;
use PhpImap\Exceptions\ConnectionException;
use Carbon\Carbon;

class ImapService
{
    protected $mailbox;

    public function __construct()
    {
        // Configuración del mailbox
        $this->mailbox = new Mailbox(
            '{' . env('IMAP_HOST') . ':' . env('IMAP_PORT') . '/' . env('IMAP_ENCRYPTION') . '}INBOX',
            env('IMAP_USERNAME'),
            env('IMAP_PASSWORD'),
            null,
            'UTF-8',
            [
                'imap_timeout' => 10, // Timeout en segundos
                'imap_timeout_read' => 10
            ]
        );
    }

    /**
     * Método para buscar el email por número de comprobante y monto.
     */
    public function searchEmailByComprobante($numeroComprobante, $montoTicket)
    {
        try {
            Log::info("Buscando comprobante ingresado: {$numeroComprobante}");
            Log::info("Monto del ticket ingresado: {$montoTicket}");
        
            // Fecha y hora actual menos 5 minutos
            $sinceDateTime = Carbon::now()->subMinutes(5);
            Log::info("Buscando correos desde: {$sinceDateTime->format('d-M-Y H:i:s')}");
        
            // Buscar correos desde la fecha ajustada
            $sinceDate = Carbon::now()->subMinutes(2)->format('d-M-Y');
            $mailsIds = $this->mailbox->searchMailbox("SINCE \"$sinceDate\"");
            Log::info("Cantidad de correos encontrados: " . count($mailsIds));
        
            if (!$mailsIds) {
                Log::warning("No se encontraron correos.");
                return ['status' => 'error', 'message' => 'No se encontraron correos recientes.'];
            }
        
            // Formatear el monto del ticket para comparación
            $formattedMontoTicket = number_format($montoTicket, 2, '.', '');
            Log::info("Monto del ticket formateado: {$formattedMontoTicket}");
        
            foreach ($mailsIds as $mailId) {
                $mail = $this->mailbox->getMail($mailId);
    
                // Verificar si el correo fue recibido en los últimos 5 minutos
                $mailDate = Carbon::parse($mail->date);
                Log::info("Fecha del correo: {$mailDate}");
                if ($mailDate->lessThan($sinceDateTime)) {
                    Log::info("Correo ignorado por estar fuera del rango de tiempo.");
                    continue;
                }
    
                $textContent = trim($mail->textPlain);
                Log::info("Contenido del correo: {$textContent}");
    
                // Extraer el número de comprobante y limpiar
                $comprobantePos = strpos($textContent, 'Ref:');
                if ($comprobantePos === false) {
                    Log::info("Referencia no encontrada en el correo.");
                    continue;
                }
                $comprobante = trim(substr($textContent, $comprobantePos + 5, 10));
                $comprobante = rtrim($comprobante, ".");
                $comprobante = mb_strtolower($comprobante, 'UTF-8');
                Log::info("Comprobante extraído: {$comprobante}");
        
                // Normalizar el comprobante ingresado
                $numeroComprobante = mb_strtolower(trim($numeroComprobante), 'UTF-8');
                Log::info("Comprobante ingresado: {$numeroComprobante}");
        
                // Extraer el monto del correo
                $montoPos = strpos($textContent, 'por $');
                if ($montoPos === false) {
                    Log::info("Monto no encontrado en el correo.");
                    continue;
                }
                $montoEndPos = strpos($textContent, ' a ', $montoPos);
                $montoEncontrado = trim(substr($textContent, $montoPos + 5, $montoEndPos - $montoPos - 5));
                $montoEncontrado = str_replace(['.', ','], ['', '.'], $montoEncontrado);
                $montoEncontrado = number_format((float)$montoEncontrado, 2, '.', '');
                Log::info("Monto encontrado (normalizado): {$montoEncontrado}");
    
                // Validar comprobante
                if ($comprobante !== $numeroComprobante) {
                    Log::warning("El comprobante no coincide: {$comprobante} !== {$numeroComprobante}");
                    return ['status' => 'error', 'message' => 'Comprobante incorrecto.'];
                }
    
                // Validar monto encontrado con el monto del ticket
                if ($montoEncontrado !== $formattedMontoTicket) {
                    Log::warning("El monto encontrado no coincide con el precio del ticket: {$montoEncontrado} !== {$formattedMontoTicket}");
                    return ['status' => 'error', 'message' => 'El monto no coincide con el precio del ticket.'];
                }
    
                Log::info("Pago verificado con éxito.");
                return ['status' => 'success', 'message' => 'Pago verificado con éxito.'];
            }
    
            Log::info("No se encontró el comprobante o el monto no coincide.");
            return ['status' => 'error', 'message' => 'No se encontró el comprobante o el monto no coincide.'];
        } catch (ConnectionException $e) {
            Log::error("Error al conectar con IMAP: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error al conectar con IMAP.'];
        } catch (\Exception $e) {
            Log::error("Error al buscar el comprobante: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Error al buscar el comprobante.'];
        }
    }
}
