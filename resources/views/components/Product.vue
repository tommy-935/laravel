<template>
	<div class="container mx-auto p-4">
		<div class="grid md:grid-cols-2 gap-6 items-center">
			<!-- Product Image Carousel -->
			<div>
				<div class="relative">
					<img :src="typeof product.images != 'undefined' ? product.images[currentImage] : ''"
						:alt="product.name" class="w-full rounded-lg shadow-md" />
					<button @click="prevImage"
						class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">&#8592;</button>
					<button @click="nextImage"
						class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full">&#8594;</button>
				</div>
				<div class="flex mt-2 space-x-2">
					<img v-for="(img, index) in product.images" :key="index" :src="img" @click="currentImage = index"
						class="w-16 h-16 cursor-pointer border-2"
						:class="{ 'border-blue-500': currentImage === index }" />
				</div>
			</div>

			<!-- Product Details -->
			<div>
				<h1 class="text-3xl font-bold mb-4">{{ product.name }}</h1>
				<p class="text-gray-700 mb-4">{{ product.short_desc }}</p>
				<p class="text-xl font-semibold text-blue-600">${{ product.price }}</p>

				<!-- Add to Cart Button -->
				<button @click="addToCartInner"
					class="mt-4 px-6 cursor-pointer py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">
					Add To Cart
				</button>
			</div>
		</div>


		<!-- Tab -->
		<div class="mt-12">
			<!-- Tab title -->
			<div class="border-b border-gray-200">
				<nav class="-mb-px flex space-x-8">
					<button @click="activeTab = 'description'" :class="{
						'border-blue-500 text-blue-600': activeTab === 'description',
						'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'description'
					}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
						Description
					</button>
					<button v-if="false" @click="activeTab = 'reviews'" :class="{
						'border-blue-500 text-blue-600': activeTab === 'reviews',
						'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews'
					}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
						Review ({{ reviews.length }})
					</button>
				</nav>
			</div>

			<!-- Tab Content -->
			<div class="py-6">
				<!-- Detail Tab -->
				<div v-if="activeTab === 'description'" class="prose max-w-none">
					<h3 v-if="false" class="text-xl font-semibold mb-4">Description</h3>
					<div v-html="product.long_desc || 'No Description'"></div>
					 <!-- 
		billingOptions="['monthly', 'yearly', 'onetime']" 
	-->
					<PricingComparisonAdvanced
						:title="'Plugin Plans'"
						:features="features"
						:plans="plans"
						:billingOptions="['onetime']"
						:teamEnabled="false"
						freeLink="/download"
						proLink="/pro"
						teamLink="/contact"
						:addToCart="addToCartInner"
					/>
				</div>

				<!-- Review Tab -->
				<div v-if="activeTab === 'reviews' && false">
					<!-- Review List -->
					<div v-if="reviews.length" class="space-y-6">
						<div v-for="review in reviews" :key="review.id" class="border-b border-gray-200 pb-6">
							<div class="flex items-center mb-2">
								<div class="flex-shrink-0">
									<span
										class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
										{{ review.user.charAt(0).toUpperCase() }}
									</span>
								</div>
								<div class="ml-3">
									<h4 class="text-sm font-medium">{{ review.user }}</h4>
									<div class="flex items-center">
										<div class="flex">
											<svg v-for="i in 5" :key="i" :class="{
												'text-yellow-400': i <= review.rating,
												'text-gray-300': i > review.rating
											}" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
												<path
													d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
											</svg>
										</div>
										<span class="ml-2 text-sm text-gray-500">{{ formatDate(review.date) }}</span>
									</div>
								</div>
							</div>
							<p class="text-gray-600">{{ review.comment }}</p>
						</div>
					</div>

					<div v-else class="text-center py-8 text-gray-500">
						No Reviews
					</div>

					<div class="mt-8 border-t border-gray-200 pt-6" v-if="false">
						<h4 class="text-lg font-medium mb-4">Review</h4>
						<form @submit.prevent="submitReview">
							<div class="mb-4">
								<label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
								<div class="flex">
									<button v-for="i in 5" :key="i" type="button" @click="newReview.rating = i"
										class="hover:text-yellow-400 focus:outline-none" :class="{
											'text-yellow-400': i <= newReview.rating,
											'text-gray-300': i > newReview.rating
										}">
										<svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
											<path
												d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
										</svg>
									</button>
								</div>
							</div>
							<div class="mb-4">
								<label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
								<textarea id="comment" v-model="newReview.comment" rows="4"
									class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
									required></textarea>
							</div>
							<button type="submit"
								class="px-4 py-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
								Submit
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Cart -->
		<div v-if="cart.length" class="mt-6 p-4 border rounded-lg bg-gray-100">
			<h2 class="text-xl font-semibold">Cart</h2>
			<ul class="mt-2">
				<li v-for="item in cart" :key="item.id" class="flex justify-between py-2">
					<span>{{ item.name }}</span>
					<span>${{ item.price }}</span>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
import { mapActions, useStore } from "vuex";
import { computed, watch, ref } from "vue";
import { useRoute } from "vue-router";
import PricingComparisonAdvanced from "./PricingComparisonAdvanced.vue";



export default {
	components: {
		PricingComparisonAdvanced
	},
	data() {
		const features = [
  { name: 'Basic Plugin Functionality', free: true, pro: true, team: true },
  { name: 'Advanced Panel', free: false, pro: true, team: true, note: 'Custom controls & UI' },
  { name: 'Email Support', free: false, pro: true, team: true },
  { name: 'Multisite Support', free: false, pro: true, team: true },
  { name: 'Team Access', free: false, pro: false, team: true, note: 'Up to 10 team members' },
]

const plans = {
  free: { price: '$0' },
  pro: {
	/*
    monthly: '$9/mo',
    yearly: '$49/yr',
	*/
    onetime: '$149',
  },
  /*
  team: {
    monthly: '$29/mo',
    yearly: '$299/yr',
    onetime: '$699',
  },
  */
}

		return {
			features,
			plans,
			product: {
				id: 1,
				name: "yyyyyyyy",
				description: "8888888888",
				longDescription: "99999999",
				price: 1299.99,
				images: [
					"https://via.placeholder.com/400/111",
					"https://via.placeholder.com/400/222",
					"https://via.placeholder.com/400/333"
				]
			},
			currentImage: 0,
			cart: [],
			activeTab: 'description',  
			reviews: [ 
				{
					id: 1,
					user: 'Tony',
					rating: 5,
					date: '2023-05-15',
					comment: 'Nice product!'
				}
			],
		
		};
	},

	setup() {
		const route = useRoute();
		const store = useStore();
		const newReview = ref({
			rating: 0,
			comment: ''
		});
		return {
			route,
			store,
			newReview
		};
	},
	mounted() {
		+ 		this.getProductInfo();
	},

	methods: {
		...mapActions(['getProduct', 'addToCart']),
		addToCartInner() {
			this.store.commit('setLoading', true);
			const cart = { product_id: this.product.id, quantity: 1 };
			this.addToCart(cart);
		},
		getProductInfo() {
			// this.cart.push({ ...this.product });
			const lastSegment = computed(() => {
				const segments = this.route.path.split('/').filter(Boolean);
				return segments[segments.length - 1] || 'home';
			});

			this.getProduct({ "handle": lastSegment.value });
			const product_info = computed(() => this.store.state.product.product);
			watch(product_info, (newProduct) => {
				this.product = newProduct;
				this.plans.pro.onetime = `$${newProduct.price}`;

			}, { immediate: true });
			console.log(this.product);
		},
		nextImage() {
			this.currentImage = (this.currentImage + 1) % this.product.images.length;
		},
		prevImage() {
			this.currentImage = (this.currentImage - 1 + this.product.images.length) % this.product.images.length;
		},

		formatDate(dateString) {
			const options = { year: 'numeric', month: 'long', day: 'numeric' };
			return new Date(dateString).toLocaleDateString(undefined, options);
		},

		submitReview() {
			const newReview = {
				id: this.reviews.length + 1,
				user: 'none',
				rating: this.newReview.rating,
				date: new Date().toISOString().split('T')[0],
				comment: this.newReview.comment
			};
			this.reviews.unshift(newReview);
			this.newReview = { rating: 0, comment: '' };
		}
	}
};
</script>

<style scoped>
.container {
	max-width: 80%;
}

.prose :deep(p) {
	margin-bottom: 1em;
	line-height: 1.6;
}

.prose :deep(ul) {
	list-style-type: disc;
	padding-left: 1.5em;
	margin-bottom: 1em;
}

.prose :deep(li) {
	margin-bottom: 0.5em;
}
</style>