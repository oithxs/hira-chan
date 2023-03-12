import { Header } from "../Header/index";
import { AppProvider } from "../../providers/app";

export const Dashboard = () => {
    return (
        <AppProvider>
            <Header />
            <div>main</div>
        </AppProvider>
    );
};
