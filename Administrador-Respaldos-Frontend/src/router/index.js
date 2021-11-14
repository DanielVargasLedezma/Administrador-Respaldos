import { createRouter, createWebHistory } from "vue-router";

import AdminArchivos from "../components/AdminArchivos.vue";

import AdminSchemas from "../components/AdminSchemas.vue";

import PerformanceBD from "../components/PerformanceBD.vue";

import AuditoriaBD from "../components/AuditoriaBD.vue";

import SeguridadUsuario from "../components/SeguridadUsuario.vue";

import TunningConsultas from "../components/tunning-tablespace/TunningConsultas.vue";
import Estadisticas from "../components/tunning-tablespace/estadisticas.vue";
import ExplainPlan from "../components/tunning-tablespace/explain-plan.vue";
import Indices from "../components/tunning-tablespace/indices.vue";

import RecuperarRespaldo from "../components/recuperar-respaldos/RecuperarRespaldo.vue";
import RecuperarSchema from "../components/recuperar-respaldos/recuperar-schema.vue";
import RecuperarTabla from "../components/recuperar-respaldos/recuperar-tabla.vue";

import CreateRespaldos from "../components/crear-respaldos/CreateRespaldos.vue";
import Schemas from "../components/crear-respaldos/respaldo-schema.vue";
import Tablas from "../components/crear-respaldos/respaldo-tabla.vue";

import AdminTablespace from "../components/admin-tablespaces/AdminTablespace.vue";
import CrearTablespace from "../components/admin-tablespaces/crear-tablespace.vue";
import EditarTablespace from "../components/admin-tablespaces/editar-tablespace.vue";
import EliminarTablespace from "../components/admin-tablespaces/eliminar-tablespace.vue";

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
        ],
      },
      {
        path: "recuperar-respaldos",
        component: RecuperarRespaldo,
        children: [
          { path: "schemas", component: RecuperarSchema },
          { path: "tablas", component: RecuperarTabla },
        ],
      },
      { path: "admin-archivos", component: AdminArchivos },
      { path: "admin-schemas", component: AdminSchemas },
      {
        path: "admin-tablespaces",
        component: AdminTablespace,
        children: [
          { path: "crear", component: CrearTablespace },
          { path: "editar", component: EditarTablespace },
          { path: "eliminar", component: EliminarTablespace },
        ],
      },
      {
        path: "tunning-consultas",
        component: TunningConsultas,
        children: [
          { path: "estadistica", component: Estadisticas },
          { path: "explainPlan", component: ExplainPlan },
          { path: "indice", component: Indices },
        ],
      },
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
