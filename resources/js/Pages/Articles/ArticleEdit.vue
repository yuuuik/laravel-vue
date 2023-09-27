<template>
    <div>
        <header class="bg-white shadow mb-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Редактирование статьи</h1>
            </div>
        </header>

        <Link :href="route('articles.index')" class="text-indigo-600 hover:text-indigo-900 my-5 block">
            Вернуться назад
        </Link>

        <!-- Форма редактирования статьи -->
        <form @submit.prevent="update" enctype="multipart/form-data">
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

                        <!-- Выбор категории -->
                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Категория</label>
                            <select
                                v-model="form.category_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            >
                                <option value="">Выберите категорию</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>

                        <!-- Поле для редактирования тегов -->
                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Теги (разделяйте запятыми)</label>
                            <input
                                v-model="form.tags"
                                type="text"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>

                        <!-- Поле для загрузки фотографии -->
                        <div class="col-span-6">
                            <label class="block text-sm font-medium text-gray-700">Фотография</label>
                            <input
                                type="file"
                                @change="updatePhoto"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                            <div class="text-red-500 mt-2" v-if="form.errors.photo">{{ form.errors.photo }}</div>
                        </div>


                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button
                        :disabled="form.processing"
                        type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Обновить
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
        Link,
    },
    props: {
        article: Object, // Принимаем статью из родительского компонента
        categories: Array, // Принимаем список категорий из родительского компонента
    },
    setup(props) {
        const form = useForm({
            title: props.article ? props.article.title : '', // Используем значения из принятой статьи
            content: props.article ? props.article.content : '', // Используем значения из принятой статьи
            category_id: props.article ? props.article.category_id : null, // Используем значение категории из принятой статьи
            photo: null,
            tags: props.article && Array.isArray(props.article.tags) ? props.article.tags.join(', ') : '',

        });

        function update() {
            if (props.article) {
                form.put(route('articles.update', props.article.id), {
                    onSuccess: () => {
                        // Действия после успешного обновления
                    },
                });
            }
        }

        function updatePhoto(event) {
            form.photo = event.target.files[0];
        }

        return { form, update, updatePhoto };
    },
};
</script>
