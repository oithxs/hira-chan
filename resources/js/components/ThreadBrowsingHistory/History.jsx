/**
 * 過去に閲覧したスレッド一覧を表示する
 *
 * @param {*} props
 * @returns
 */
export const History = (props) => {
    const threads = props.history.map((accessLog, index) => {
        const url = "/dashboard/thread/name=" + accessLog.hub.name + "&id=" + accessLog.hub.id;
        return (
            <tr key={index}>
                <td className="a-block">
                    <a href={url}>{accessLog.hub.name}</a>
                </td>
                <td>
                    <button onClick={() => { props.onClick(accessLog.hub) }}>
                        閲覧
                    </button>
                </td>
            </tr>
        );
    });

    return (
        <table className="table">
            <thead className="table-info">
                <tr>
                    <th>スレッド名</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {threads}
            </tbody>
        </table>
    );
};
