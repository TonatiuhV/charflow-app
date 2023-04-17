<template>
    <div class="grid grid-cols-4">
      <div class="col-span-3 h-screen" >
        <screen ref="screen" :markers="[]">
          <group v-if="groupNodes" :nodes="$refs.sidebar.filterNodes || graph.nodes">
          </group>

          <edge v-for="edge in graph.edges" :data="edge" :nodes="graph.nodes" :key="edge.id">
          </edge>

          <node v-for="node in graph.nodes" :data="node" :key="node.id">
          </node>
        </screen>
      </div>
      <sink-sidebar class="flex-2" :graph="graph" @toggleGroupNodes="toggleGroupNodes" ref="sidebar">
      </sink-sidebar>
    </div>
  </template>

  <script>
  import SinkSidebar from './SinkSidebar.vue'
  import { Screen, Node, Edge, Group, graph } from 'vnodes'


  export default {
    components: {
      Screen,
      Node,
      Edge,
      Group,
      SinkSidebar
    },
    data() {
      return {
        graph: new graph(),
        groupNodes: false,
      }
    },
    methods: {
      toggleGroupNodes(bool) {
        this.groupNodes = bool
      },
    },
  }
  </script>

  <style>
  </style>
