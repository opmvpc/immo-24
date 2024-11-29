<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import FormSection from "@/Components/FormSection.vue";

const form = useForm({
    title: "",
    description: "",
    price: 0,
    address: "",
    bedrooms_count: 0,
    space: 0,
});

const onSubmit = () => {
    form.post(route("houses.store"));
};
</script>

<template>
    <AppLayout title="Créer une maison">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Créer une nouvelle maison
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <FormSection @submitted="onSubmit">
                    <template #title> Informations de la maison </template>

                    <template #description>
                        Remplissez les informations pour créer une nouvelle
                        maison.
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
                                min="0"
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
                                min="0"
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
                                min="0"
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
                            Créer la maison
                        </PrimaryButton>
                    </template>
                </FormSection>
            </div>
        </div>
    </AppLayout>
</template>
