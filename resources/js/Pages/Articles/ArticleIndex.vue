<template>
    <div>
        <Head :title="title" />

        <header class="bg-white shadow mb-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ title }}</h1>
            </div>
        </header>

        <Link :href="route('articles.indexCreate')" class="text-indigo-600 hover:text-indigo-900 my-5 block">
            Добавить статью
        </Link>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div v-if="articles.total > 0" class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Заголовок
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Фотография
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Содержание
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Категории
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Теги
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Действия</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="article in articles.data" :key="article.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ article.title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img v-if="article.photo_path" :src="'/storage/' + article.photo_path" alt="Фотография" class="max-w-32 max-h-32 h-auto" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a :href="route('articles.show', article.id)" class="text-sm font-medium text-gray-900">{{ shortenContent(article.content, 50) }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ article.category ? article.category.name : 'Нет категории' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ article.tags.map(tag => tag.name).join(', ') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end items-center space-x-3">
                                <Link :href="route('articles.indexEdit', article.id)" class="text-indigo-600 hover:text-indigo-900">Редактировать</Link>
                                <a @click="destroy(article.id)" class="text-red-600 hover:text-red-900 cursor-pointer">Удалить</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <Pagination :links="articles.links" />
                </div>

                <div v-else class="text-center font-bold text-xl">
                    Статей пока нет
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Shared/Pagination';

export default {
    components: {
        Head,
        Link,
        Pagination,
    },
    props: {
        title: String,
        articles: Object,
    },
    methods: {
        destroy(id) {
            if (confirm('Вы уверены?')) {
                this.$inertia.delete(this.route('articles.destroy', id));
            }
        },

        shortenContent(text, length) {
            if (text.length <= length) {
                return text;
            } else {
                const shortenedText = text.substring(0, length);
                return `${shortenedText} ... `;
            }
        },
    },
};
</script>
