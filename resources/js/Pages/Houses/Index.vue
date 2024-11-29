<script setup>
import Pagination from "@/Components/Pagination.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import {
    HomeIcon,
    MapPinIcon,
    BanknotesIcon,
    ArrowsPointingOutIcon,
} from "@heroicons/vue/24/outline";
import BedDoubleIcon from "@/Components/Icons/BedDoubleIcon.vue";

const props = defineProps(["houses"]);

// Formatter pour le prix (parce qu'on n'est pas des sauvages)
const formatPrice = (price) => {
    return new Intl.NumberFormat("fr-FR", {
        style: "currency",
        currency: "EUR",
        maximumFractionDigits: 0,
    }).format(price);
};

// Formatter pour la surface (parce que 42 != 42m²)
const formatSpace = (space) => `${space} m²`;
</script>

<template>
    <AppLayout title="Maisons">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Maisons
                </h2>
                <Link
                    :href="route('houses.create')"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors duration-300"
                >
                    Ajouter une maison
                </Link>
            </div>
        </template>

        <div
            class="pt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-6"
        >
            <Link
                v-for="house in houses.data"
                :key="house.id"
                :href="route('houses.edit', house)"
                class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300"
            >
                <!-- Gallery avec overlay au hover -->
                <div class="relative aspect-[4/3] overflow-hidden">
                    <div
                        v-if="house.photos.length"
                        class="grid grid-cols-2 gap-0.5"
                    >
                        <img
                            v-for="(photo, index) in house.photos.slice(0, 4)"
                            :key="index"
                            :src="`/storage/${photo.path}`"
                            :alt="photo.alt"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div
                        v-else
                        class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center"
                    >
                        <HomeIcon class="w-16 h-16 text-gray-400" />
                    </div>
                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    />
                </div>

                <!-- Contenu -->
                <div class="p-4">
                    <!-- Titre et Prix -->
                    <div class="mb-3">
                        <h3
                            class="text-xl font-semibold text-gray-900 dark:text-white mb-1 capitalize"
                        >
                            {{ house.title }}
                        </h3>
                        <div
                            class="flex items-center text-indigo-600 dark:text-gray-300 font-bold text-2xl"
                        >
                            <BanknotesIcon class="w-5 h-5 mr-2 text-gray-400" />
                            {{ formatPrice(house.price) }}
                        </div>
                    </div>

                    <!-- Infos principales -->
                    <div
                        class="space-y-2 text-sm text-gray-600 dark:text-gray-300"
                    >
                        <div class="flex items-center">
                            <MapPinIcon class="w-5 h-5 mr-2 text-gray-400" />
                            {{ house.address }}
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <BedDoubleIcon
                                    class="w-5 h-5 mr-1 text-gray-400"
                                />
                                {{ house.bedrooms_count }} ch.
                            </div>
                            <div class="flex items-center">
                                <ArrowsPointingOutIcon
                                    class="w-5 h-5 mr-1 text-gray-400"
                                />
                                {{ formatSpace(house.space) }}
                            </div>
                        </div>
                    </div>

                    <!-- Description tronquée -->
                    <p
                        v-if="house.description"
                        class="mt-3 text-sm text-gray-500 dark:text-gray-400 line-clamp-2"
                    >
                        {{ house.description }}
                    </p>
                </div>
            </Link>
        </div>

        <Pagination :pagination="houses" class="px-6 py-8" />
    </AppLayout>
</template>
