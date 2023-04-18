
<script setup>
import { nextTick, onBeforeMount, ref } from "vue";
import { Screen, Node, Edge, Group, graph } from "vnodes";

const graphNode = ref(new graph());
const groupNodes = ref(false);
const screenNode = ref(null);

onBeforeMount(() => {
  nextTick(() => {
    createNodes();
  });
});

const createNodes = () => {
  graphNode.value.reset();
  const GRAPH = [{ id: "1", children: [] }];
  const visitNode = (node, parent) => {
    if (!graphNode.value.nodes.find((n) => n.id === node.id)) {
      graphNode.value.createNode(node.id);
    }
    if (parent) {
      if (
        !graphNode.value.edges.find(
          (c) => c.fromNode === parent.id && c.toNode === parent.id
        )
      ) {
        graphNode.value.createEdge(parent.id, node.id);
      }
    }
    node.children.forEach((c) => visitNode(c, node));
  };
  GRAPH.forEach((n) => visitNode(n));
  centerNodes();
};

const centerNodes = () => {
  const panzoom = screenNode.value.panzoom;
  zoomNodes();
  if (panzoom.getZoom() > 1) {
    zoomNodes(1); // fix, only allow zoom out
  }
};

const zoomNodes = (scale = null) => {
  let left = Infinity;
  let top = Infinity;
  let right = -Infinity;
  let bottom = -Infinity;

  const nodes = graphNode.value.nodes;
  nodes.forEach((node) => {
    if (node.x < left) left = node.x;
    if (node.x + node.width > right) right = node.x + node.width;
    if (node.y < top) top = node.y;
    if (node.y + node.height > bottom) bottom = node.y + node.height;
  });

  left -= 50;
  top -= 50;
  right += 50;
  bottom += 50;

  screenNode.value.zoomRect({ left, top, right, bottom }, { scale });
};
</script>
<template>
  <div class="col-span-3 h-screen">
    <screen ref="screenNode" :markers="[]">
      <edge
        v-for="edge in graphNode.edges"
        :data="edge"
        :nodes="graphNode.nodes"
        :key="edge.id"
      >
      </edge>

      <node v-for="node in graphNode.nodes" :data="node" :key="node.id"> </node>
    </screen>
  </div>
</template>

<style lang="scss" scoped>
</style>
