package sg.edu.nus.bombsquad;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.toolbox.StringRequest;

import java.util.HashMap;
import java.util.Map;

public class GetQuestionIDRequest extends StringRequest {
    private static final String GET_QUESTION_ID_REQUEST_URL = "http://orbitalbombsquad.x10host.com/getQuestionID.php";
    private Map<String, String> params;

    public GetQuestionIDRequest(String room_code, Response.Listener<String> listener) {
        super(Request.Method.POST, GET_QUESTION_ID_REQUEST_URL, listener, null);
        params = new HashMap<>();
        params.put("room_code", room_code);
    }

    @Override
    public Map<String, String> getParams(){
        return params;
    }
}