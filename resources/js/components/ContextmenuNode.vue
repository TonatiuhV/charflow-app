
<script setup>
import { nextTick, onMounted, ref, watchEffect } from "vue";
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
});

const contextmenuNode = ref(null);

const postionMenu = () => {
  let x = props.event.offsetX,
    y = props.event.offsetY,
    winWidth = window.innerWidth / 2,
    winHeight = window.innerHeight / 2,
    cmWidth = contextmenuNode.value.offsetWidth,
    cmHeight = contextmenuNode.value.offsetHeight;
  console.log(cmHeight, cmWidth, x, y, winWidth, winHeight);
  //   if (x > winWidth - cmWidth - shareMenu.offsetWidth) {
  //     shareMenu.style.left = "-200px";
  //   } else {
  //     shareMenu.style.left = "";
  //     shareMenu.style.right = "-200px";
  //   }
  x = x > winWidth - cmWidth ? winWidth - cmWidth - 5 : x;
  y = y > winHeight - cmHeight ? winHeight - cmHeight - 5 : y;

  console.log(x, y);
  contextmenuNode.value.style.left = `${winWidth + props.node.x - cmHeight}px`;
  contextmenuNode.value.style.top = `${winHeight + props.node.y + cmWidth}px`;
};

watchEffect(() => {
  if (props.open) {
    nextTick(() => {
      console.log(contextmenuNode.value);
      postionMenu();
    });
  }
});
</script>
<template>
  <Teleport to="body">
    <div
      ref="contextmenuNode"
      v-if="open"
      class="absolute z-50 w-20 bg-white border rounded shadow"
    >
      <p>Hello contentmenu!</p>
      <button @click="open = false">Close</button>
    </div>
  </Teleport>
</template>


<style lang="scss" scoped>
</style>
