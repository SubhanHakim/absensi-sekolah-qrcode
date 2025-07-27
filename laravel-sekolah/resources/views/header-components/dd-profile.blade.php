@php
    $user = Auth::user();
    $initial = $user->name ? strtoupper(substr($user->name, 0, 1)) : '';
@endphp


<div class="hs-dropdown relative inline-flex [--placement:bottom-right] [--trigger:click]">
    <a class="relative hs-dropdown-toggle cursor-pointer align-middle rounded-full">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-600 text-white text-lg font-bold">
            {{ $initial }}
        </div>
    </a>
    <div
        class="card hs-dropdown-menu transition-[opacity,margin] rounded-md duration hs-dropdown-open:opacity-100 opacity-0 mt-2 min-w-max w-[200px] hidden z-[12]">
        <div class="card-body p-0 py-2">
            <div class="px-4 mt-[7px] grid">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="btn-outline-primary font-medium text-[15px] w-full hover:bg-blue-600 hover:text-white">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
