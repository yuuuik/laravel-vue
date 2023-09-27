<template>
    <div>
        <header class="bg-white shadow mb-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Создание статьи</h1>
            </div>
        </header>

        <Link :href="route('articles.index')" class="text-indigo-600 hover:text-indigo-900 my-5 block">
            Вернуться назад
        </Link>

        <form @submit.prevent="store" enctype="multipart/form-data">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Заголовок</label>
                            <input
                                :class="{'border-red-500': form.errors.title}"
                                v-model="form.title"
                                type="text"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                            <div class="text-red-500 mt-2" v-if="form.errors.title">{{ form.errors.title }}</div>
                        </div>

                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Содержание</label>
                            <textarea
                                :class="{'border-red-500': form.errors.content}"
                                v-model="form.content"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            ></textarea>
                            <div class="text-red-500 mt-2" v-if="form.errors.content">{{ form.errors.content }}</div>
                        </div>

                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Категория</label>
                            <select
                                v-model="form.category_id"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            >
                                <option value="" disabled selected>Выберите категорию</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                            <div class="text-red-500 mt-2" v-if="form.errors.category_id">{{ form.errors.category_id }}</div>
                        </div>

                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Теги (разделяйте запятыми)</label>
                            <input
                                v-model="form.tags"
                                type="text"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>

                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Загрузить изображение</label>
                            <input
                                @change="updatePhoto"
                                type="file"
                                accept="image/*"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                            <div class="text-red-500 mt-2" v-if="form.errors.photo">{{ form.errors.photo }}</div>
                        </div>
                    </div>

                    <!-- Предварительный просмотр изображения -->
                    <div v-if="form.previewUrl">
                        <img :src="form.previewUrl" alt="Предварительный просмотр" class="mt-2 max-w-xs" />
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button
                        :disabled="form.processing"
                        type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Создать
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { Link, useForm } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link
    },
    props: {
        categories: Array, // Передаем список категорий
    },
    setup() {
        const form = useForm({
            title: '',
            content: '',
            category_id: null,
            photo: null,
            tags: '', // Добавляем поле для тегов
            previewUrl: null,
        });

        function store() {
            const formData = new FormData();
            formData.append('title', form.title);
            formData.append('content', form.content);
            formData.append('category_id', form.category_id);
            formData.append('photo', form.photo);
            formData.append('tags', form.tags); // Добавляем теги

            form.post(route('articles.store'), formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onSuccess: () => {
                    form.reset();
                },
                onError: (errors) => {
                    form.errors = errors;
                },
            });
        }

        function updatePhoto(event) {
            form.photo = event.target.files[0];

            if (form.photo) {
                form.previewUrl = URL.createObjectURL(form.photo);
            }
        }

        return { form, store, updatePhoto };
    },
};
</script>
