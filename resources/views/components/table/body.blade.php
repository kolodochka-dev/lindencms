@props([
    'code' => '',
])

<tbody class="">
    @if ((string) $slot)
        {{ $slot }}
    @else
        <tr>
            <td colspan="1000" class="px-6 py-22 text-center">
                <div class="flex flex-col items-center justify-center">
                    <x-cms::i icon="ph:empty-light" class="text-gray-400" width="50" height="50" />
                    <p class="text-gray-400 text-lg">No records found</p>
                </div>
            </td>
        </tr>
    @endif
</tbody>
