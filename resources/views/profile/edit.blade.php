@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <!-- Encabezado con iniciales -->
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-20 h-20 rounded-full bg-primary-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr(Auth::user()->nombre_completo ?? Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Mi Perfil</h2>
                        <p class="text-gray-500">Información de tu cuenta</p>
                    </div>
                </div>

                <!-- Información del usuario (solo lectura) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-800">
                            {{ Auth::user()->nombre_completo ?? Auth::user()->name }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-800">
                            {{ Auth::user()->email }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-800">
                            {{ Auth::user()->telefono ?? 'No registrado' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Área</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-800">
                            {{ Auth::user()->area->nombre ?? 'Sistema' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-800">
                            @if(Auth::user()->rol == 'Administrador general')
                                <span class="badge badge-danger">Administrador general</span>
                            @elseif(Auth::user()->rol == 'Administrador de área')
                                <span class="badge badge-warning">Administrador de área</span>
                            @elseif(Auth::user()->rol == 'Jefe de área')
                                <span class="badge badge-info">Jefe de área</span>
                            @else
                                <span class="badge badge-secondary">Usuario</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Último acceso</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-800">
                            @if(Auth::user()->last_login_at)
                                {{ \Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d/m/Y H:i') }}
                            @else
                                Nunca
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Botón para volver -->
                <div class="mt-6 flex justify-end">
                    <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection