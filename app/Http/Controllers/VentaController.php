<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Ticket;
use Carbon\Carbon;
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        // return response()->json([
        //     'success' => false,
        //     'message' => $request->all(),
        // ], 400);
        try {
            $messages = [
                'required' => 'El campo :attribute es obligatorio.',
                'integer' => 'El campo :attribute debe ser un número entero.',
                'exists' => 'El :attribute especificado no existe.',
                'numeric' => 'El campo :attribute debe ser un número.',
                'min' => 'El campo :attribute no puede ser negativo.',
                'string' => 'El campo :attribute debe ser una cadena de texto.',
                'date' => 'El campo :attribute debe ser una fecha válida.',
            ];
    
            $validatedData = $request->validate([
                'usuario_id' => 'required|integer|exists:usuarios,usuario_id',
                'generalTickets' => 'required|integer|min:0',
                'starTickets' => 'required|integer|min:0',
            ]);
        } catch (ValidationException $e) {
            //throw $th;
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
        if ($validatedData['generalTickets'] == 0 && $validatedData['starTickets'] == 0) {
            # code...
            return response()->json([
                'errors' => ['Al menos uno de los tickets debe ser mayor a cero.']
            ], 422);
        }
        
        $venta = new Venta();
        $venta->usuario_id = $validatedData['usuario_id'];
        $venta->tipo_pago = 'online';
        $venta->fecha = now();

        $now = now();
        $turno_manana = now()->setTime(13, 0, 0);
        
        if ($now->greaterThan($turno_manana)) {
            $venta->monto_total = $validatedData['starTickets'] * 30;
        }
        else{
            $venta->monto_total = $validatedData['generalTickets'] * 10;
        }


        if ($venta->save()) {
            $ticket = new Ticket();
            $ticket->venta_id = $venta->venta_id;
            $ticket->turno = 'mañana';
            if ($now->greaterThan($turno_manana)) {
                $ticket->tipo_ticket_id = 2;
                $ticket->cantidad = $validatedData['starTickets'];
            }
            else{
                $ticket->tipo_ticket_id = 1;
                $ticket->cantidad = $validatedData['generalTickets'];
            }
            // $ticket->cantidad = $validatedData['generalTickets'];
            $ticket->precio = $venta->monto_total;

            $usuario = $venta->usuario;

            $ticket->QR_ticket = $usuario->dni . rand(1000, 9999) . Carbon::parse($venta->fecha)->format('H:i') . $ticket->venta_id;            $ticket->save();

            return response()->json([
                'success' => true,
                'message' => 'Compra realizada con éxito',
                'venta' => $venta
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Error al pagar',
            ], 400);
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $venta = Venta::where('venta_id', $id)->with('tickets')->first();
        if ($venta) {
            # code...
            return response()->json(['venta'=>$venta], 200);
        }
        else{
            return response()->json(['message'=>'Venta no encontrada'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function boletos(){
        $boletos = Venta::all();
        return response()->json(['boletos'=>$boletos], 200);
    }

    public function ventasXusuario($id){
        $ventas = Venta::where('usuario_id', $id)->with('tickets')->latest()->get();
        return response()->json(['ventas'=>$ventas], 200);
    }
}
