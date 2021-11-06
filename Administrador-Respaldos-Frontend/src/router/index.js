import { createRouter, createWebHistory } from "vue-router";

import AdminArchivos from "../components/AdminArchivos.vue";
import AdminSchemas from "../components/AdminSchemas.vue";
import CreateRespaldos from "../components/CreateRespaldos.vue";
import TunningConsultas from "../components/TunningConsultas.vue";
import PerformanceBD from "../components/PerformanceBD.vue";
import RecuperarRespaldo from "../components/RecuperarRespaldo.vue";
import AdminTablespace from "../components/AdminTablespace.vue";
import AuditoriaBD from "../components/AuditoriaBD.vue";
import SeguridadUsuario from "../components/SeguridadUsuario.vue";

import Schemas from "../components/crear-respaldos/respaldo-schema.vue";
import Tablas from "../components/crear-respaldos/respaldo-tabla.vue";
import Full from "../components/crear-respaldos/respaldo-full.vue";

import Home from "../components/Home.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
    children: [
      {
        path: "crear-respaldos",
        component: CreateRespaldos,
        children: [
          { path: "schemas", component: Schemas },
          { path: "tablas", component: Tablas },
          { path: "full", component: Full },
        ],
      },
      { path: "recuperar-respaldos", component: RecuperarRespaldo },
      { path: "admin-archivos", component: AdminArchivos },
      { path: "admin-schemas", component: AdminSchemas },
      { path: "admin-tablespaces", component: AdminTablespace },
      { path: "tunning-consultas", component: TunningConsultas },
      { path: "performance-bd", component: PerformanceBD },
      { path: "auditoria-bd", component: AuditoriaBD },
      { path: "seguridad-usuarios", component: SeguridadUsuario },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
