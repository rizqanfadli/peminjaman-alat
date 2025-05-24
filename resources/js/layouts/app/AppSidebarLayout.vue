<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar" class="min-h-screen bg-white text-gray-800 transition-colors duration-300 dark:bg-gray-900 dark:text-white">
        <AppSidebar class="border-r border-gray-200 bg-gray-100 dark:border-gray-700 dark:bg-gray-800" />
        <AppContent variant="sidebar" class="bg-white dark:bg-gray-900">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" class="bg-white dark:bg-gray-900" />
            <div class="p-4">
                <slot />
            </div>
        </AppContent>
    </AppShell>
</template>
