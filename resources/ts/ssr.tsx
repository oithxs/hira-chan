import React from "react";
import ReactDOMServer from "react-dom/server";
import { createInertiaApp } from "@inertiajs/react";
import createServer from "@inertiajs/react/server";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import route from "../../vendor/tightenco/ziggy/dist/index.m";

const appName: string = import.meta.env.VITE_APP_NAME ?? "Laravel";

createServer(
    async (page) =>
        await createInertiaApp({
            page,
            render: ReactDOMServer.renderToString,
            title: (title) => `${title} - ${appName}`,
            resolve: async (name) =>
                await resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob("./Pages/**/*.tsx")),
            setup: ({ App, props }) => {
                global.route = (name, params, absolute) =>
                    route(name, params, absolute, {
                        // @ts-expect-error unknown
                        ...page.props.ziggy,
                        // @ts-expect-error unknown
                        location: new URL(page.props.ziggy.location),
                    });

                return <App {...props} />;
            },
        }),
);
