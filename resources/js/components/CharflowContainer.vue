
<script setup>
import { nextTick, onBeforeMount, reactive, ref } from "vue";
import { Screen, Edge, graph } from "vnodes";
import NodeInicio from "./NodeInicio.vue";
import NodeNotificacion from "./NodeNotificacion.vue";
import ContextmenuNode from "./ContextmenuNode.vue";

const graphNode = ref(new graph());
const groupNodes = ref(false);
const inputValue = ref("");
const screenNode = ref(null);
const screenContainer = ref(null);
const cntmenuNode = reactive({ open: false, event: {} });
const selectNode = ref({});

const processNode = ref([
  {
    id: "1",
    type: "NodeInicio",
    data: {
      name: "Incio",
    },
    children: [
      {
        id: "2",
        type: "NodeNotificacion",
        data: {
          name: "Notificacion",
        },
        children: [],
      },
    ],
  },
]);

//
const nodesData = ref([]);

onBeforeMount(() => {
  nextTick(() => {
    createNodes();
  });
});

const createNodes = () => {
  graphNode.value.reset();
  nodesData.value = [];
  const visitNode = (node, parent) => {
    // const { children, ...rest } = node;

    if (!graphNode.value.nodes.find((n) => n.id === node.id)) {
      graphNode.value.createNode({ ...node });
    }
    if (parent) {
      if (
        !graphNode.value.edges.find(
          (c) => c.fromNode === parent.id && c.toNode === parent.id
        )
      ) {
        graphNode.value.createEdge({ ...parent }, { ...node });
      }
    }
    node.children.forEach((c) => visitNode(c, node));
  };
  processNode.value.forEach((n) => visitNode(n));
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

const getComponent = (type) => {
  switch (type) {
    case "NodeInicio":
      return NodeInicio;
    case "NodeNotificacion":
      return NodeNotificacion;
    default:
      return NodeInicio;
  }
};

const showNode = (event, node) => {
  console.log(event, node);
  alert("Click en node: " + node.data.name);
};

const showOptionsNode = (event, node) => {
  cntmenuNode.event = event;
  selectNode.value = node;
  cntmenuNode.open = true;
  //   alert("Click en node: " + node.data.name);
};
const closeContextmenu = () => {
  cntmenuNode.event = {};
  selectNode.value = {};
  cntmenuNode.open = false;
};
</script>
<template>
  <div class="h-screen" ref="screenContainer">
    <screen ref="screenNode" :markers="[]">
      <edge
        v-for="edge in graphNode.edges"
        :data="edge"
        :nodes="graphNode.nodes"
        :key="edge.id"
      >
      </edge>
      <component
        v-for="node in graphNode.nodes"
        :key="node.id"
        :is="getComponent(node.type)"
        :node="node"
        @show="($event, node) => showNode($event, node)"
        @contextmenu="($event, node) => showOptionsNode($event, node)"
      />
    </screen>
    <contextmenu-node
      :open="cntmenuNode.open"
      :event="cntmenuNode.event"
      :screenContainer="screenContainer"
      :node="selectNode"
      @close="closeContextmenu()"
    />
  </div>
</template>

<style lang="scss" scoped>
</style>
