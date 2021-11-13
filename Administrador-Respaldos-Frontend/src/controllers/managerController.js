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

    console.log(file.type);

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
};
