<div class="w-full sm:w-1/4 px-6 py-4 border-r border-gray-400">
    <h3 class="font-semibold text-lg mb-4">Categories</h3>
    <form action="{{ route('products') }}" method="GET" id="filter-form">
        <ul class="space-y-2">
            <li>
                <input type="checkbox" name="category[]" value="all" id="select-all" 
                    @if(!request()->has('category') || in_array('all', request()->category)) checked @endif>
                <label for="all" class="text-gray-700">All</label>
            </li>
            @foreach($categories as $categoryItem)
                <li>
                    <input type="checkbox" name="category[]" value="{{ $categoryItem->id }}" 
                    @if(in_array($categoryItem->id, request()->category ?? [])) checked @endif
                    class="category-checkbox"
                    data-category-id="{{ $categoryItem->id }}">
                    <label for="category_{{ $categoryItem->id }}" class="text-gray-700">{{ $categoryItem->name }}</label>
                </li>
            @endforeach
        </ul>
        <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md">Filter</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        const form = document.getElementById('filter-form');

        selectAllCheckbox.addEventListener('change', function() {
            if (this.checked) {
                categoryCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
            }
        });

        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    if ([...categoryCheckboxes].every(box => !box.checked)) {
                        selectAllCheckbox.checked = true;
                    }
                }
            });
        });
    });
</script>
