<script setup>
import { ref } from "vue";
const open = ref(false);
</script>
<template>
  <li
    class="relative flex font-semibold text-base"
    @mouseenter="open = true"
    @mouseleave="open = false"
  >
    <div class="py-2 px-2 hover:bg-gray-600 hover:text-white">
      <slot name="tigger" />
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-4 h-4 inline-block"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M8.25 4.5l7.5 7.5-7.5 7.5"
        />
      </svg>
    </div>
    <ul
      v-show="open"
      class="bg-white top-2 left-32 border rounded-md shadow absolute"
    >
      <slot name="content" />
    </ul>
  </li>
</template>

