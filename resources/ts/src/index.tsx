import * as ReactDOM from "react-dom/client";
import { Dashboard } from "./components/Layouts/index";
import { AppProvider } from "./providers/app";

/**
 * 指定された id に指定されたレイアウトを表示する
 *
 * @param element 表示する要素 (id)
 * @param Layout 表示する JSX.Element
 */
const Render = (element: HTMLElement | null, Layout: CallableFunction) => {
    const root: ReactDOM.Root = ReactDOM.createRoot(element as Element);
    const App: CallableFunction = Layout;

    root.render(
        <AppProvider>
            <App />
        </AppProvider>
    );
};

/** id="dashboard" の部分にダッシュボードを表示する */
if (document.getElementById("dashboard")) {
    Render(document.getElementById("dashboard"), Dashboard);
}
