<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
</head>
<body class="bg-gray-100">
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="text-2xl font-bold">
            <a href="{{ url('/') }}">My Website</a>
        </div>
        <div>
            @if(Auth::check())
                <div class="flex items-center space-x-4">
                    <div class="text-gray-600">{{ Auth::user()->name }}</div>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Log Out</button>
                    </form>
                </div>
            @else
                <a href="/login" class="bg-blue-500 text-white px-4 py-2 rounded">Log In</a>
            @endif
        </div>
    </div>
</header>
<main class="max-w-7xl mx-auto mt-8">
    <div class="flex">
        <aside class="w-1/4 bg-white p-4 shadow rounded-lg">
            <h2 class="text-xl font-bold mb-4">Filters</h2>
            <form action="{{ url('/') }}" method="GET" id="filter-form">
                <div class="mb-4">
                    <label class="block text-gray-700">Category</label>
                    <input type="text" id="category-search" placeholder="Search categories" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <select id="category-select" class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" multiple>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>
                <div id="selected-categories" class="mb-4">
                    <!-- Selected categories will be displayed here -->
                </div>
                <input type="hidden" name="categories" id="categories-input">
                <div class="mb-4">
                    <label class="block text-gray-700">Price Range</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Apply Filters</button>
            </form>
        </aside>
        <section class="w-3/4 ml-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                        <p class="text-gray-600">{{ $product->description }}</p>
                        <div class="mt-2 text-gray-900 font-semibold">${{ number_format($product->price, 2) }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </section>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const categorySearchInput = document.getElementById('category-search');
        const categorySelect = document.getElementById('category-select');
        const selectedCategoriesContainer = document.getElementById('selected-categories');
        const categoriesInput = document.getElementById('categories-input');
        let selectedCategories = [];

        categorySearchInput.addEventListener('input', _.debounce(async function() {
            const query = this.value;
            try {
                const response = await axios.get('{{ route('search.categories') }}', { params: { query } });
                const categories = response.data;

                categorySelect.innerHTML = '';
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        }, 300));

        categorySelect.addEventListener('change', function() {
            const selectedOptions = Array.from(this.selectedOptions);
            selectedCategories = selectedOptions.map(option => ({
                id: option.value,
                name: option.textContent
            }));
            updateSelectedCategories();
        });

        function updateSelectedCategories() {
            selectedCategoriesContainer.innerHTML = '';
            selectedCategories.forEach(category => {
                const categoryDiv = document.createElement('div');
                categoryDiv.classList.add('bg-blue-100', 'text-blue-700', 'px-4', 'py-2', 'rounded', 'inline-block', 'mr-2', 'mb-2', 'cursor-pointer');
                categoryDiv.textContent = category.name;
                categoryDiv.addEventListener('click', () => removeCategory(category.id));
                selectedCategoriesContainer.appendChild(categoryDiv);
            });
            categoriesInput.value = selectedCategories.map(category => category.id).join(',');
        }

        function removeCategory(id) {
            selectedCategories = selectedCategories.filter(category => category.id !== id);
            updateSelectedCategories();
        }
    });
</script>
</body>
</html>
