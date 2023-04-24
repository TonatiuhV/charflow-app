
<script setup>
import { nextTick, onMounted, onUnmounted, ref, watchEffect } from "vue";
import ItemMenuContext from "./ItemMenuContext.vue";
import ItemMenuContextDrawer from "./ItemMenuContextDrawer.vue";
const emit = defineEmits(["close"]);

const props = defineProps({
  open: {
    type: Boolean,
    defualt: false,
  },
  node: {
    type: Object,
    required: true,
  },
  event: {},
  screenContainer: {
    required: true,
  },
});

const contextmenuNode = ref(null);

const postionMenu = () => {
  const rect = props.screenContainer.getBoundingClientRect();
  const postionCenterContainer = {
    left: rect.left + window.scrollX + props.screenContainer.clientWidth / 2,
    top: rect.top + window.scrollY + props.screenContainer.clientHeight / 2,
  };
  let x = postionCenterContainer.left + props.event.offsetX;
  let y = props.event.offsetY + postionCenterContainer.top;
  const cmHeight = contextmenuNode.value.offsetHeight;

  //   console.log(
  //     "x: " + x,
  //     "y: " + y,
  //     "cmWidth: " + cmWidth,
  //     "cmHeight: " + cmWidth
  //   );
  contextmenuNode.value.style.left = `${x + props.node.x - 15}px`;
  contextmenuNode.value.style.top = `${y + props.node.y - 25}px`;
};

watchEffect(() => {
  if (props.open) {
    nextTick(() => {
      postionMenu();
    });
  }
});

const closeOnEscape = (e) => {
  if (props.open && e.keyCode === 27) {
    emit("close");
  }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));
</script>
<template>
  <Teleport to="body">
    <div v-if="open">
      <div class="fixed inset-0 z-40" @click="emit('close')"></div>
      <div
        ref="contextmenuNode"
        class="absolute z-50 bg-white border py-2 rounded-md shadow w-fit"
      >
        <ul class="cursor-pointer">
          <ItemMenuContextDrawer>
            <template #tigger> NUEVO NODO </template>
            <template #content>
              <ItemMenuContext class="relative">NOTIFICACION</ItemMenuContext>
              <ItemMenuContext class="relative">CONDICION</ItemMenuContext>
            </template>
          </ItemMenuContextDrawer>
        </ul>
      </div>
    </div>
  </Teleport>
</template>


<style lang="scss" scoped>
</style>
