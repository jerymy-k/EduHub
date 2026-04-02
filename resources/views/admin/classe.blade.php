<x-app-layout>
    @if (session('success'))
                <div
                    class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 shadow-sm rounded-r-lg flex items-center">
                    <span class="material-symbols-outlined mr-2">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    <form action="classe-add" class="border-2 border-black" method="POST">
        <div class="flex flex-col">
            <label for="">Classe Name</label>
            <input type="text" name="class_name" required>
        </div>
        <div class="flex flex-col">
            <label for="">Assigned To</label>
            <select name="teacher_id" required>
                <option disabled selected>Choose Teacher For This Class</option>
                @foreach ($teacherNotAssigned as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
            @if (count($teacherNotAssigned) == 0)
                <span>There is no teacher to be assigned</span>
            @endif
        </div>
        <button type="submit">Add Classe</button>
    </form>
    <table class="border border-black">
        <thead>
            <tr>
                <th class="border border-black">Class Name</th>
                <th class="border border-black">Class Year</th>
                <th class="border border-black">Class Teacher</th>
                <th class="border border-black">Edit Class</th>
                <th class="border border-black">Deactive Class</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($classes as $classe)
                <tr>
                    <td class="border border-black">{{ $classe->name }}</td>
                    <td class="border border-black">{{ $classe->year }}</td>
                    @forelse ($classe->teachers as $teacher)
                        <td class="border border-black">{{ $teacher->name }}</td>
                    @empty
                        <td>non teacher assigne to this class</td>
                    @endforelse
                    <td class="border border-black">
                        <button x-data=""
                            x-on:click.prevent ="$dispatch('open-modal' , 'classe-edit');
                     $dispatch('set-edit-classe' ,{{ json_encode($classe) }})
                     ">edit</button>
                    </td>
                    <td class="border border-black">
                        <form action="{{ route('classe-delete', $classe->id) }}" method="POST"
                            onsubmit="return confirm('Delete this Classe?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">delete</button>
                        </form>
                    </td>
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>
    <x-modal name="classe-edit">
        <div x-data="{ classe: {}, allTeachers: {{ json_encode($allTeachers) }} }" x-on:set-edit-classe.window="classe = $event.detail">
            <form action="classe-edit" method="POST">
                @csrf
                <input type="text" name="id" x-bind:value="classe.id" hidden>
                <label>name</label>
                <input type="text" name="class_name" x-bind:value="classe.name">
                <label>Assigned Teacher</label>
                <select name="teacher_id" required x-model="classe.teacher_id">
                    <option x-text= >Choose Teacher</option>
                    <template x-for="teacher in allTeachers">
                        <option :value="teacher.id" x-text="teacher.name" :selected="teacher.id === classe.teachers[0].id"></option>
                    </template>
                </select>
                <button type="submit">edit classe</button>
            </form>
        </div>
    </x-modal>
</x-app-layout>
