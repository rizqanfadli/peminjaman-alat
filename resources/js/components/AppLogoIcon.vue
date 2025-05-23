<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img 
        :src="`../storage/Logo/TKJ.png`"
        alt="Logo TKJ"
        :class="className"
        v-bind="$attrs"
        style="height: auto; width: auto;"
    />
</template>
