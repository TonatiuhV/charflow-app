<script setup>
import { Node } from "vnodes";
const emits = defineEmits(["show", "contextmenu"]);
const props = defineProps({
  node: {
    type: Object,
    required: true,
  },
});
</script>
<template>
  <node :data="node">
    <div
      class="px-3 py-1 bg-green-500 rounded cursor-pointer"
      @dblclick="emits('show', $event, node)"
      @contextmenu.prevent="emits('contextmenu', $event, node)"
    >
      <strong class="text-white">{{ node.data.name }}</strong>
    </div>
  </node>
</template>



<style lang="scss" scoped>
</style>
