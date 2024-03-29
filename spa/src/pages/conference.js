import {h} from 'preact';
import {useState, useEffect} from "preact/compat";
import {findComments} from "../api/api";

function Comment({comments}) {
    if (null !== comments && 0 === comments.length) {
        return <div className="text-center pt-4">No comments yet.</div>;
    }

    if (!comments) {
        return <div className="text-center pt-4">Loading...</div>;
    }

    return (
        <div className="pt-4">
            {comments.map(comment => (
                <div className="shadow border rounded-lg p-3 mb-4">
                    <div className="comment-img mr-3">
                        {!comment.photoFilename ? '' : (
                            <a href={ENV_API_ENDPOINT + 'uploads/photos/' + comment.photoFilename} target="_blank">
                                <img src={ENV_API_ENDPOINT + 'uploads/photos/' + comment.photoFilename} alt=""/>
                            </a>
                        )}
                    </div>

                    <h5 className="font-weight-light mt-3 mb-0">{comment.author}</h5>
                    <div className="comment-text">{comment.text}</div>
                </div>
            ))}
        </div>
    );
}

export default function Conference({conferences, slug}) {
    const conference = conferences.find(conference => conference.slug === slug);
    const [comments, setComments] = useState(null);

    useEffect(_ => {
        findComments(conference).then(setComments);
    }, [slug]);

    return (
        <div className="p-3">
            <h4>{conference.city} {conference.year}</h4>
            <Comment comments={comments}/>
        </div>
    );
};
