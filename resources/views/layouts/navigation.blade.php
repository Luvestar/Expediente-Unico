@php
    $currentGuard = session('current_guard', 'web');
    $user = Auth::guard($currentGuard)->user();
@endphp

<!-- Settings Dropdown -->
<div class="hidden sm:flex sm:items-center sm:ms-6">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="flex items-center space-x-3 focus:outline-none">
                <div class="text-right">
                    <div class="font-medium text-gray-700">
                        {{ $user->nombre_completo ?? $user->name ?? 'Usuario' }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $user->area->nombre ?? ($currentGuard == 'admin' ? 'Administrador' : 'Sistema') }}
                    </div>
                </div>
                <div class="w-9 h-9 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($user->nombre_completo ?? $user->name ?? 'U', 0, 1)) }}
                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                <i class="fas fa-user-circle text-gray-500"></i>
                <span>Mi Perfil</span>
            </x-dropdown-link>

            <div class="border-t border-gray-200 my-1"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center gap-2 text-red-600">
                    <i class="fas fa-sign-out-alt text-red-500"></i>
                    <span>Cerrar sesión</span>
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>