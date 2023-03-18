import { Layout as Thread } from "../../features/thread";
import { Header } from "../Header/index";

/**
 * ダッシュボードを表示する
 *
 * @return {JSX.Element}
 */
export const Dashboard = () => {
    return (
        <>
            <Header />
            <div className="container-fluid">
                {/* とりあえず表示 */}
                <Thread />
            </div>
        </>
    );
};
