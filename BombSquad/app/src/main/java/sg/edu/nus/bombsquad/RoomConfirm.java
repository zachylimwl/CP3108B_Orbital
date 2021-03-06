package sg.edu.nus.bombsquad;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.TypedValue;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CheckedTextView;
import android.widget.LinearLayout;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class RoomConfirm extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_room_confirm);

        //To show on Android Monitor onCreate
        System.out.println("Activity Name: RoomConfirm");

        display();
    }

    private void display() {
        final Intent intent = getIntent();
        Global global = Global.getInstance();
        final boolean[] selected = global.getBooleanArray();
        final String[] selected_name = global.getStringArray();
        try {
            JSONObject bomb = new JSONObject(intent.getStringExtra("bomb"));
            LinearLayout ll = (LinearLayout) findViewById(R.id.roomConfirmScroll);
            LinearLayout.LayoutParams lp = new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT);
            int i = 0;
            int j = 0;
            while (i < 100000) {
                if (selected[i]) {
                    CheckedTextView ctv = new CheckedTextView(this);
                    ctv.setTextSize(TypedValue.COMPLEX_UNIT_SP, 30);
                    ctv.setTextColor(Color.WHITE);
                    ctv.setText(selected_name[i]);
                    assert ll != null;
                    ll.addView(ctv, lp);
                    j++;
                }
                i++;
            }
        }
        catch(JSONException e) {
            e.printStackTrace();
        }

        //Button: create room
        Button createRoom = (Button)findViewById(R.id.createRoom);
        assert createRoom != null;
        createRoom.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String user_id = intent.getStringExtra("user_id");

                int k = 0;
                while(k < 100000) {
                    if (selected[k]) {
                        Response.Listener<String> responseListener = new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                            }
                        };
                        CreateRoomRequest createRoomRequest = new CreateRoomRequest(user_id, intent.getStringExtra("room_name"),
                                intent.getStringExtra("room_code"), k, 0, 0, 0, responseListener);
                        RequestQueue queue = Volley.newRequestQueue(RoomConfirm.this);
                        queue.add(createRoomRequest);
                    }
                    k++;
                }

                Intent intentRoom = new Intent(RoomConfirm.this, RoomType.class);
                intentRoom.putExtra("bomb", intent.getStringExtra("bomb"));
                intentRoom.putExtra("user_id", intent.getStringExtra("user_id"));
                intentRoom.putExtra("room_name", intent.getStringExtra("room_name"));
                intentRoom.putExtra("room_code", intent.getStringExtra("room_code"));
                startActivity(intentRoom);
            }
        });
    }

}