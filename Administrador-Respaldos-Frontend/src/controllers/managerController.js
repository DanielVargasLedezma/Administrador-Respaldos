"use strict";

import { global } from "../api-url/global";
import axios from "axios";

export default {
  getSchemas: async () => {
    return await axios
      .get(global.url + "schemas")
      .then((res) => {
        return res.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  getRol: async (schema) => {
    return await axios
      .get(global.url + `roles-schema/${schema}`)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  getTablesFromSchema: async (schema) => {
    return await axios
      .get(global.url + "schemas/tablas/" + schema)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doASchemaBackUp: async (schema) => {
    return await axios
      .get(global.url + "backup/schemas/" + schema)
      .then((response) => {
        return response;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  deleteASchemaBackUp: async (schema) => {
    return await axios
      .delete(global.url + "backup/schemas/" + schema)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doATableSchemaBackUp: async (schema, table) => {
    return await axios
      .get(global.url + `backup/schemas/tables/${schema}/${table}`)
      .then((response) => {
        return response;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  deleteATableSchemaBackUp: async (schema, table) => {
    return await axios
      .delete(global.url + `backup/schemas/tables/${schema}/${table}`)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doADatabaseBackUp: async () => {
    return await axios
      .get(global.url + "backup/full")
      .then((response) => {
        return response;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  deleteADatabaseBackUp: async () => {
    return await axios
      .delete(global.url + "backup/full")
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doASchemaRestore: async (schema, file) => {
    const data = new FormData();

    data.append("file", file, file.name);

    return await axios
      .post(global.url + "recover/schemas/" + schema, data)
      .then((response) => {
        return response;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doEstadisticasTabla: async (schema, tabla) => {
    const formData = new FormData();

    formData.append("schema", schema);
    formData.append("tabla", tabla);

    return await axios
      .post(global.url + "estadistica/tabla", formData)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doEstadisticasSchema: async (schema) => {
    const formData = new FormData();

    formData.append("schema", schema);

    return await axios
      .post(global.url + "estadistica/schema", formData)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doAnalizarTabla: async (schema, tabla) => {
    const formData = new FormData();

    formData.append("schema", schema);
    formData.append("tabla", tabla);

    return await axios
      .post(global.url + "analize-table/schema", formData)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doAnalizarSchema: async (schema) => {
    const formData = new FormData();

    formData.append("schema", schema);

    return await axios
      .post(global.url + "analize/schema", formData)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doMonitoreo: async () => {
    return await axios
      .get(global.url + "monitoreo")
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doMonitoreo2: async () => {
    return await axios
      .get(global.url + "monitoreo2")
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  doMonitoreo3: async () => {
    return await axios
      .get(global.url + "monitoreo3")
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  /*doMonitoreo2: async (mon) => {
    return await axios
      .get(global.url + "monitoreo2/" + mon)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },*/
  deleteASchemaRestoreFile: async (schema) => {
    return await axios
      .delete(global.url + "recover/schemas/" + schema)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  getPublicPath: async () => {
    return await axios
      .get(global.url + "path")
      .then((res) => {
        return res.data;
      })
      .catch((error) => {
        throw error;
      });
  },
  getTablespaces: async () => {
    return await axios
      .get(global.url + "tablespaces")
      .then((res) => {
        return res.data;
      })
      .catch((error) => {
        throw error;
      });
  },
  getColumnTables: async (schema, table) => {
    return await axios
      .get(global.url + `columns/${schema}/${table}`)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  loadPriv: async () => {
    return await axios
      .get(global.url + "privileges")
      .then((response) => {
        return response;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  createRol: async (rol_name, privilegios) => {
    const formData = new FormData();

    let privilegios_rol = "";

    privilegios.forEach((element, index) => {
      if (index === privilegios.length - 1) {
        privilegios_rol += element;
      } else {
        privilegios_rol += element + "|";
      }
    });

    formData.append("rol_name", rol_name);
    formData.append("privilegios_rol", privilegios_rol);

    return await axios
      .post(global.url + "create/rol", formData)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  createTablespace: async (tablespace_name) => {
    const formData = new FormData();

    formData.append("name", tablespace_name);

    return await axios
      .post(global.url + "create/tablespace", formData)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  createTemporaryTablespace: async (tablespace_name) => {
    const formData = new FormData();

    formData.append("name", tablespace_name);

    return await axios
      .post(global.url + "create/temporary-tablespace", formData)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  createIndexOnTable: async (schema, table, fields) => {
    const formData = new FormData();

    let campos = "";

    fields.forEach((element, index) => {
      if (index === fields.length - 1) {
        campos += element;
      } else {
        campos += element + ", ";
      }
    });

    formData.append("schema", schema);
    formData.append("table", table);
    formData.append("campos", campos);

    return await axios
      .post(global.url + "create-index/schema", formData)
      .then((response) => {
        return response;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  deleteTablespace: async (tablespace) => {
    return await axios
      .delete(global.url + "delete/tablespace/" + tablespace)
      .then((response) => {
        return response.status;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  resizeTablespace: async (tablespace, size) => {
    const formData = new formData();

    formData.append("tablespace", tablespace);
    formData.append("size", size);

    return await axios
      .post(global.url + "tablespaces/resize", formData)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  resizeTemporaryTablespace: async (tablespace, size) => {
    const formData = new formData();

    formData.append("tablespace", tablespace);
    formData.append("size", size);

    return await axios
      .post(global.url + "temporary-tablespaces/resize", formData)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  asignarRolAUsuario: async (user, rol) => {
    return await axios
      .get(global.url + `asignar-rol/${user}/${rol}`)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
  desasignarRolAUsuario: async (user, rol) => {
    return await axios
      .get(global.url + `desasignar-rol/${user}/${rol}`)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error.response;
      });
  },
};
