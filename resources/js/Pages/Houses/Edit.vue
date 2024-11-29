<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm, router } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import ActionSection from "@/Components/ActionSection.vue";
import FormSection from "@/Components/FormSection.vue";
import { ref } from "vue";
import DropzoneUpload from "@/Components/DropzoneUpload.vue";

const props = defineProps({
    house: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    title: props.house.title,
    description: props.house.description,
    price: props.house.price,
    address: props.house.address,
    bedrooms_count: props.house.bedrooms_count,
    space: props.house.space,
});

const onSubmit = () => {
    form.put(route("houses.update", props.house.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Modifier une maison">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier {{ house.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <FormSection @submitted="onSubmit">
                    <template #title> Informations de la maison </template>

                    <template #description>
                        Modifiez les informations principales de la maison.
                    </template>

                    <template #form>
                        <!-- Titre -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="title" value="Titre" />
                            <TextInput
                                id="title"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError
                                :message="form.errors.title"
                                class="mt-2"
                            />
                        </div>

                        <!-- Prix -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="price" value="Prix" />
                            <TextInput
                                id="price"
                                v-model="form.price"
                                type="number"
                                class="mt-1 block w-full"
                                required
                                min="1"
                            />
                            <InputError
                                :message="form.errors.price"
                                class="mt-2"
                            />
                        </div>

                        <!-- Adresse -->
                        <div class="col-span-6">
                            <InputLabel for="address" value="Adresse" />
                            <TextInput
                                id="address"
                                v-model="form.address"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError
                                :message="form.errors.address"
                                class="mt-2"
                            />
                        </div>

                        <!-- Nombre de chambres -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel
                                for="bedrooms_count"
                                value="Nombre de chambres"
                            />
                            <TextInput
                                id="bedrooms_count"
                                v-model="form.bedrooms_count"
                                type="number"
                                class="mt-1 block w-full"
                                required
                                min="1"
                            />
                            <InputError
                                :message="form.errors.bedrooms_count"
                                class="mt-2"
                            />
                        </div>

                        <!-- Surface -->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="space" value="Surface (m²)" />
                            <TextInput
                                id="space"
                                v-model="form.space"
                                type="number"
                                class="mt-1 block w-full"
                                required
                                min="1"
                            />
                            <InputError
                                :message="form.errors.space"
                                class="mt-2"
                            />
                        </div>

                        <!-- Description -->
                        <div class="col-span-6">
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300"
                                rows="4"
                                required
                            />
                            <InputError
                                :message="form.errors.description"
                                class="mt-2"
                            />
                        </div>
                    </template>

                    <template #actions>
                        <Link
                            :href="route('houses.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Annuler
                        </Link>
                        <PrimaryButton
                            class="ml-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Mettre à jour
                        </PrimaryButton>
                    </template>
                </FormSection>
            </div>
        </div>

        <!-- Section Photos -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ActionSection>
                    <template #title> Photos de la maison </template>

                    <template #description>
                        Ajoutez ou supprimez les photos de la maison.
                    </template>

                    <template #content>
                        <div class="space-y-6">
                            <!-- Grille de photos -->
                            <div
                                v-if="house.photos?.length"
                                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
                            >
                                <div
                                    v-for="photo in house.photos"
                                    :key="photo.id"
                                    class="relative group"
                                >
                                    <img
                                        :src="`/storage/${photo.path}`"
                                        :alt="photo.alt"
                                        class="w-full h-48 object-cover rounded-lg"
                                    />
                                    <Link
                                        as="button"
                                        :href="
                                            route('photos.destroy', photo.id)
                                        "
                                        method="delete"
                                        preserve-scroll
                                        class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                                        title="Supprimer la photo"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </Link>
                                </div>
                            </div>

                            <!-- Message si pas de photos -->
                            <div
                                v-else
                                class="text-center text-gray-500 dark:text-gray-400"
                            >
                                Aucune photo n'a été ajoutée pour cette maison.
                            </div>

                            <DropzoneUpload
                                :upload-url="route('photos.store', house.id)"
                            />
                        </div>
                    </template>
                </ActionSection>
            </div>
        </div>
    </AppLayout>
</template>
