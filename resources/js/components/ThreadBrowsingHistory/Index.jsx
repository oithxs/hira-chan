import React from "react";
import ReactDOM from "react-dom/client";
import { History } from "./History";
import { Posts } from "./Posts";

/**
 * 引数のスレッドの書き込みを取得し，posts にセットする
 *
 * 閲覧履歴の「閲覧」ボタンクリックで実行
 *
 * @param {*} thread
 * @param {*} setPosts
 */
const handleClick = async (thread, setPosts) => {
    fetch("/jQuery.ajax/getRow", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.head.querySelector(
                'meta[name="csrf-token"]'
            ).content,
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            thread_id: thread.id,
            max_message_id: 0,
        }),
    })
        .then((response) => {
            return response.json();
        })
        .then((json) => {
            setPosts(json);
        });
};

/**
 * 閲覧履歴ページの表示を行う
 *
 * @returns
 */
const Index = () => {
    const [posts, setPosts] = React.useState({});
    const element = document.getElementById("thread_browsing_history");
    const history = JSON.parse(element.dataset.history);

    return (
        <div className="container">
            <div className="row">
                <div className="py-8 col-5">
                    <History
                        history={history}
                        onClick={(thread) => handleClick(thread, setPosts)}
                    />
                </div>
                <div className="col-1"></div>
                <div className="py-8 col-6">
                    <Posts posts={posts} />
                </div>
            </div>
        </div>
    );
};

const threadBrowsingHistory = ReactDOM.createRoot(
    document.getElementById("thread_browsing_history")
);
threadBrowsingHistory.render(<Index />);
