/**
 * 引数として渡されたスレッドへの書き込みを元に，スレッドの書き込みを表示する
 *
 * @param {*} props
 * @returns
 */
export const Posts = (props) => {
    const specialCharacterSets = {
        "&amp;": "&",
        "&lt;": "<",
        "&gt;": ">",
        "&ensp;": " ",
        "&emsp;": "　",
        "<br>": "\n",
        "&ensp;&ensp;": "\t",
    };
    let posts = [];

    for (let i = props.posts.length - 1; i >= 0; i--) {
        let message = props.posts[i].message;
        for (let key in specialCharacterSets) {
            message = message.replaceAll(key, specialCharacterSets[key]);
        }

        posts = posts.concat(
            <div key={i}>
                <p>
                    {props.posts[i].message_id}: {props.posts[i].user.name}{" "}
                    {props.posts[i].created_at}
                </p>
                <p className="ow-break-word" style={{ whiteSpace: "pre-line" }}>
                    {message}
                </p>
                <br></br>
                <hr></hr>
            </div>
        );
    }

    return (
        <div className="overflow-hidden sm:rounded-lg sticky">
            <div className="row px-3 bg-primary bg-opacity-25">
                <div className="col-sm-12 col-xs-12 bg-secondry thread-posts">
                    {posts}
                </div>
            </div>
        </div>
    );
};
