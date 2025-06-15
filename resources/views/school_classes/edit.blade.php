<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <div>
                <h2 class="font-semibold text-xl">Edit Kelas</h2>
            </div>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>
    <div class="min-h-[80vh] flex items-center justify-center bg-gray-100 py-8">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold mb-2 text-blue-700 text-center">Edit Kelas</h3>
            <p class="text-gray-500 mb-6 text-center">Perbarui data kelas dan wali kelas di bawah ini.</p>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('school_classes.update', $school_class) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Nama Kelas</label>
                    <input type="text" name="class_name" value="{{ $school_class->class_name }}"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                </div>
                <div class="mb-6">
                    <label class="block mb-1 font-medium text-gray-700">Wali Kelas</label>
                    <select name="homeroom_teacher"
                        class="w-full border rounded px-3 py-2 focus:ring focus:border-blue-400" required>
                        <option value="">Pilih Guru</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}"
                                {{ $school_class->homeroom_teacher == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }} ({{ $guru->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Update</button>
                <a href="{{ route('school_classes.index') }}"
                    class="block text-center mt-3 text-gray-600 hover:underline">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
