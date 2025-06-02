<div>
    <div class="inline-flex gap-x-2">
        <select wire:model="year"
            class="py-3 px-4 pe-5 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
            <option selected="">Năm</option>
            @foreach (range(now()->year - 10, now()->year) as $y)
            <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>
        <select wire:model="month"
            class="py-3 px-4 pe-5 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
            <option selected="">Tháng</option>
            @foreach (range(1, 12) as $m)
            <option value="{{ $m }}">{{ Carbon\Carbon::create()->month($m)->locale('vi')->isoFormat('MMMM') }}
            </option>
            @endforeach
        </select>
        <select wire:model="grade"
            class="py-3 px-4 pe-5 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
            <option selected="">Lớp</option>
            @foreach ($grades as $grade)
            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
            @endforeach
        </select>
        <button type="button" wire:click="fetchStudents()"
            class="flex shrink-0 justify-center items-center gap-2 size-9.5 text-sm font-medium rounded-lg border border-transparent bg-green-500 text-white hover:bg-green-600 focus:outline-hidden focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
        {{-- Phần nút export to excel đã được xóa --}}
    </div>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        @if ($year && $month && $grade)
        <div class="flex flex-col mt-1">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-2xs overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                        <div
                            class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                    Điểm danh
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">
                                    Quản lý điểm danh.
                                </p>
                            </div>

                            <div>

                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead
                                class="bg-gray-50 divide-y divide-gray-200 dark:bg-neutral-800 dark:divide-neutral-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start border-s border-gray-200 dark:border-neutral-700">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            Tên sinh viên
                                        </span>
                                    </th>
                                    @foreach (range(1, $daysInMonth) as $day)
                                    <th scope="col"
                                        class="px-6 py-3 text-start border-s border-gray-200 dark:border-neutral-700">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            {{ $day }}
                                            <select wire:change="markAll({{ $day }}, $event.target.value)"
                                                class="dark:bg-neutral-900">
                                                <option value="">Tất cả</option>
                                                <option value="present">Có mặt</option>
                                                <option value="absent">Vắng mặt</option>
                                                <option value="sick">Ốm</option>
                                                <option value="other">Khác</option>
                                            </select>
                                        </span>
                                    </th>
                                    @endforeach

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @foreach ($students as $student)
                                <tr :key="{{ $student->id }}">
                                    <td class="h-px w-auto whitespace-nowrap">
                                        <div class="px-6 py-2">
                                            <span
                                                class="font-semibold text-sm text-gray-800 dark:text-neutral-200">{{ $student->last_name }}
                                                {{ $student->first_name }} </span>
                                            {{-- <span class="text-xs text-gray-500 dark:text-neutral-500">(23.16%)</span> --}}
                                        </div>
                                    </td>
                                    @foreach (range(1, $daysInMonth) as $day)
                                    <td class="h-px w-auto whitespace-nowrap">
                                        <div class="px-6 py-2">
                                            <select
                                                wire:change="updateAttendance({{ $student->id}}, {{ $day }}, $event.target.value )"
                                                class="dark:bg-neutral-900">
                                                <option value="present"
                                                    {{ $attendance[$student->id][$day] == 'present' ? 'selected' : ''}}>
                                                    Có mặt</option>
                                                <option value="absent"
                                                    {{ $attendance[$student->id][$day] == 'absent' ? 'selected' : ''}}>
                                                    Vắng mặt</option>
                                                <option value="sick"
                                                    {{ $attendance[$student->id][$day] == 'sick' ? 'selected' : ''}}>
                                                    Ốm</option>
                                                <option value="other"
                                                    {{ $attendance[$student->id][$day] == 'other' ? 'selected' : ''}}>
                                                    Khác</option>
                                            </select>
                                        </div>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>