import * as ReactDOM from "react-dom/client";
import { Dashboard } from "./components/Layouts/index";
import { AppProvider } from "./providers/app";

const Render = (element: HTMLElement | null, Dashboard: CallableFunction) => {
    const root: ReactDOM.Root = ReactDOM.createRoot(element as Element);
    const App: CallableFunction = Dashboard;

    root.render(
        <AppProvider>
            <App />
        </AppProvider>
    );
};

if (document.getElementById("dashboard")) {
    Render(document.getElementById("dashboard"), Dashboard);
}
