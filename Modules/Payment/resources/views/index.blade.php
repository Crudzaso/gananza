@extends('payment::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Gestión de Pagos</h1>
    <a href="{{ route('payment.create') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Nuevo Pago</a>

    <div class="bg-white shadow-lg rounded-lg mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Rifa</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Monto</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Método de Pago</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Fecha de Pago</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($payments as $payment)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4">{{ $payment->user->name }}</td>
                    <td class="px-6 py-4">{{ $payment->raffle->name }}</td>
                    <td class="px-6 py-4">{{ $payment->amount }}</td>
                    <td class="px-6 py-4">{{ $payment->payment_method }}</td>
                    <td class="px-6 py-4">{{ $payment->payment_date }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('payment.edit', $payment->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
                        <form action="{{ route('payment.destroy', $payment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>
@endsection
