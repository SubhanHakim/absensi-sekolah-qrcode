{{-- filepath: resources/views/school_classes/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Kelas</h2>
    </x-slot>

    <form action="{{ route('school_classes.update', $school_class) }}" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Nama Kelas</label>
            <input type="text" name="class_name" value="{{ $school_class->class_name }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Wali Kelas</label>
            <input type="text" name="homeroom_teacher" value="{{ $school_class->homeroom_teacher }}" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('school_classes.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</x-app-layout>