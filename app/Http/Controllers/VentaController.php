<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        return response()->json([
            'success' => false,
            'message' => $request->all(),
        ], 400);
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
                'cliente_id' => 'required|integer|exists:clientes,cliente_id',
                'usuario_id' => 'required|integer|exists:usuarios,usuario_id',
                'monto_total' => 'required|numeric|min:0',
                'tipo_pago' => 'required|string',
                'fecha' => 'required|date',
                'token_culqi' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            //throw $th;
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
        

        $venta = new Venta($validatedData);
        // $venta->save();

        if ($venta->save()) {
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
}
