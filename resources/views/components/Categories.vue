<template>
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Categories</h1>

            <div class="w-full md:w-64">
                <input v-model="searchQuery" type="text" placeholder="Search Product..."
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="mb-6 flex flex-wrap gap-2">
            <button v-for="category in categories" :key="category" @click="toggleCategory(category)" :class="[
                'px-3 py-1 rounded-full text-sm border transition-colors',
                selectedCategories.includes(category)
                    ? 'bg-blue-100 border-blue-300 text-blue-600'
                    : 'bg-white border-gray-200 hover:bg-gray-50'
            ]">
                {{ category }}
            </button>
        </div>

        <div v-if="loading" class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div v-for="n in 8" :key="n" class="bg-white rounded-lg overflow-hidden shadow-sm">
                <div class="aspect-square bg-gray-200 animate-pulse"></div>
                <div class="p-3 space-y-2">
                    <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-3 bg-gray-200 rounded animate-pulse w-3/4"></div>
                    <div class="h-3 bg-gray-200 rounded animate-pulse w-1/2"></div>
                </div>
            </div>
        </div>

        <div v-else class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div v-for="product in paginatedProducts" :key="product.id"
                class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden">
                    <a :href="'/products/' + product.uri">
                        <img :src="product.image" :alt="product.name"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                            loading="lazy">
                        <span v-if="product.isNew"
                            class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            New
                        </span>
                    </a>
                </div>

                <div class="p-3">
                    <h3 class="font-medium text-gray-800 line-clamp-1 mb-1">{{ product.name }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-2">{{ product.description }}</p>

                    <div class="flex justify-between items-center">
                        <span class="text-red-500 font-bold">¥{{ product.price }}</span>
                        <button @click="addToCart(product)"
                            class="text-sm bg-blue-100 text-blue-600 hover:bg-blue-200 px-2 py-1 rounded transition-colors">
                            Buy
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <button v-if="hasMore && !loading" @click="loadMore"
                class="px-6 py-2 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                More
            </button>
            <div v-else-if="!hasMore" class="text-gray-500 py-2">
                No More
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, toRaw, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const loading = ref(true);
const products = ref([]);
const searchQuery = ref('');
const selectedCategories = ref([]);
const currentPage = ref(1);
const itemsPerPage = 8;

const store = useStore();
const { dispatch } = useStore();

/*
mapActions([
            "getPruducts"
        ]);
        */
const route = useRoute();

const lastSegment = computed(() => {
  const segments = route.path.split('/').filter(Boolean); // 分割并过滤空值
  return segments[segments.length - 1] || 'home'; 
});

dispatch('getProducts', {"slug": lastSegment.value});


const slug = defineProps({
    slug: {
        type: String,
        required: true
    }
});

const fetchProducts = async () => {
    loading.value = true;
    try {
        await new Promise(resolve => setTimeout(resolve, 800));
        // const products = await getPruducts();

        const mockProducts = [
            {
                id: 1,
                name: 'Ipoad Pro',
                description: 'shoisui  suuusuis usuis',
                price: 399,
                category: 'slug1',
                image: 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500',
                isNew: true
            }
        ];

        const product_list = computed(() => store.state.product.productList)
        watch(product_list, (newValue) => {
            products.value = [...newValue];
        }, { immediate: true });
       // products.value = toRaw(product_list.value);
        
    } catch (error) {
        console.error('Failed:', error);
    } finally {
        loading.value = false;
    }
};

const categories = computed(() => {
    const allCategories = products.value.map(p => p.category);
    return [...new Set(allCategories)];
});

const filteredProducts = computed(() => {
    return products.value.filter(product => {
        const categoryMatch = selectedCategories.value.length === 0 ||
            selectedCategories.value.includes(product.category);

        const searchMatch = product.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            product.description.toLowerCase().includes(searchQuery.value.toLowerCase());

        return categoryMatch && searchMatch;
    });
});

const paginatedProducts = computed(() => {
    const start = 0;
    const end = currentPage.value * itemsPerPage;
    return filteredProducts.value.slice(0, end);
});

const hasMore = computed(() => {
    return paginatedProducts.value.length < filteredProducts.value.length;
});

const toggleCategory = (category) => {
    const index = selectedCategories.value.indexOf(category);
    if (index === -1) {
        selectedCategories.value.push(category);
    } else {
        selectedCategories.value.splice(index, 1);
    }
    currentPage.value = 1; 
};

const loadMore = () => {
    currentPage.value += 1;
};

const addToCart = (product) => {
    console.log('add:', product);
    alert(`${product.name} added to cart`);
};

onMounted(() => {
    fetchProducts();
});
</script>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.aspect-square {
    aspect-ratio: 1/1;
}
</style>