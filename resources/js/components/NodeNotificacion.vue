<script setup>
import { Node } from "vnodes";
const emits = defineEmits(["show"]);
const props = defineProps({
  node: {
    type: Object,
    required: true,
  },
});
console.log(props.node);
</script>
<template>
  <node :data="node">
    <div
      class="px-3 py-1 cursor-pointer bg-blue-500 rounded"
      @dblclick="emits('show', $event, node)"
      @contextmenu.prevent="emits('contextmenu', $event, node)"
    >
      <strong class="text-white">{{ node.data.name }}</strong>
    </div>
  </node>
</template>



<style lang="scss" scoped>
</style>
