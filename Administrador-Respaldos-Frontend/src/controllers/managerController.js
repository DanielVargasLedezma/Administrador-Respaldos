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
};
