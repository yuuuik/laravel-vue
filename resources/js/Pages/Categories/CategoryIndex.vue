<template>
    <div>
        <header class="bg-white shadow mb-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ title }}</h1>
            </div>
        </header>

        <Link :href="route('categories.create')" class="text-indigo-600 hover:text-indigo-900 my-5 block">
            Создать категорию
        </Link>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div v-if="categories.length > 0" class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Имя категории
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Действия</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="category in categories" :key="category.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ category.name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link :href="route('categories.edit', category.id)" class="text-indigo-600 hover:text-indigo-900">Редактировать</Link>
                                <a @click="destroy(category.id)" class="text-red-600 hover:text-red-900 cursor-pointer ml-2">Удалить</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <Pagination :links="categories.links" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Pagination from '../../Shared/Pagination';

export default {
    components: {
        Link,
        Pagination,
    },
    props: {
        title: String,
        categories: Array,
    },
    methods: {
        destroy(id) {
            if (confirm('Вы уверены?')) {
                this.$inertia.delete(this.route('categories.destroy', id));
            }
        },
    },
};
</script>
