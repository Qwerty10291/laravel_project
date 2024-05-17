<div class="space-y-6">
    
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $category?->name)" autocomplete="name" placeholder="Name"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
    </div>
    <div>
        <x-input-label for="products_count" :value="__('Products Count')"/>
        <x-text-input id="products_count" name="products_count" type="text" class="mt-1 block w-full" :value="old('products_count', $category?->products_count)" autocomplete="products_count" placeholder="Products Count"/>
        <x-input-error class="mt-2" :messages="$errors->get('products_count')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>