<template>
    <Head :title="article.title" />

    <header class="bg-white shadow mb-10">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">{{ article.title }}</h1>
                <div class="space-x-4">
                    <button @click="redirectToIndex" class="text-indigo-600 hover:text-indigo-900">Назад</button>
                    <Link :href="route('articles.indexEdit', article.id)" class="text-indigo-600 hover:text-indigo-900">Редактировать</Link>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg prose-indigo" v-html="article.content"></div>
        <img v-if="article.photo_path" :src="'/storage/' + article.photo_path" alt="Фотография" class="max-w-full h-auto" />
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Head,
        Link,
    },
    props: {
        article: Object,
    },
    methods: {
        redirectToIndex() {
            this.$inertia.visit(route('articles.index'));
        },
    },
}
</script>
