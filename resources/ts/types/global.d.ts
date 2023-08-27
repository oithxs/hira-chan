import { type AxiosInstance } from "axios";
import type ziggyRoute from "ziggy-js";
import { type Config as ZiggyConfig } from "ziggy-js";

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    // eslint-disable-next-line no-var
    var route: typeof ziggyRoute;
    // eslint-disable-next-line no-var
    var Ziggy: ZiggyConfig;
}
