package com.emenu.zhenw.emenucustomersapp;

import android.app.ListActivity;
import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.entity.BufferedHttpEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;


public class MainActivity extends ListActivity {
    private ProgressDialog pDialog;
    JSONParser jParser = new JSONParser();
    ArrayList<String> cuisineType;
    ArrayList<HashMap<String, String>> cuisine;
    private static String url_all_products =
            "http://98.157.156.155:8080/androidphp/Android_Get_CuisineType.php";
    private static String url_images = "http://98.157.156.155:8080/sources/cuisines/photos/";
    private static String url_intros = "http://98.157.156.155:8080/sources/cuisines/intros/";
    private static final String TAG_SUCCESS = "success";
    private static final String TAG_HASCUISINE = "hasCuisine";
    private static final String TAG_CUISINETYPES = "cuisineTypes";
    private static final String TAG_TYPE = "type";
    private static final String TAG_NAME = "name";
    private static final String TAG_PRICE = "price";
    private static final String TAG_IMAGE = "image";
    private static final String TAG_INTRO = "intro";
    private String choiceType;
    private ListView cuisineTypeList;
    private HashMap<String, Integer> typeMap;

    JSONArray types = null;
    JSONArray cuisines = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        cuisineTypeList = (ListView) findViewById(R.id.cuisineTypeList);
        cuisineType = new ArrayList<String>();
        cuisine = new ArrayList<HashMap<String, String>>();
        typeMap = new HashMap<String, Integer>();
        new LoadCuisineTypes().execute();

        cuisineTypeList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                choiceType = ((TextView) view.findViewById(R.id.cuisineType)).getText().toString();
                cuisine = new ArrayList<HashMap<String, String>>();
                new LoadCuisines().execute();
            }
        });
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    private class LoadCuisineTypes extends AsyncTask<String, String, String> {
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(MainActivity.this);
            pDialog.setMessage("Loading products. Please wait...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(false);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            List<NameValuePair> params = new ArrayList<NameValuePair>();
            // getting JSON string from URL
            JSONObject json = jParser.makeHttpRequest(url_all_products, "GET", params);

            // Check your log cat for JSON reponse
            Log.d("All Products: ", json.toString());

            try {
                // Checking for SUCCESS TAG
                int success = json.getInt(TAG_SUCCESS);

                if (success == 1) {
                    // products found
                    // Getting Array of Products
                    types = json.getJSONArray(TAG_CUISINETYPES);

                    // looping through All Products
                    for (int i = 0; i < types.length(); i++) {
                        JSONObject c = types.getJSONObject(i);

                        // Storing each json item in variable
                        String type = c.getString(TAG_TYPE);
                        int hasCuisine = c.getInt(TAG_HASCUISINE);
                        typeMap.put(type, hasCuisine);

                        // adding HashList to ArrayList
                        cuisineType.add(type);
                    }
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }

            return null;
        }

        protected void onPostExecute(String file_url) {
            // dismiss the dialog after getting all products
            pDialog.dismiss();
            // updating UI from Background Thread
            runOnUiThread(new Runnable() {
                public void run() {
                    /**
                     * Updating parsed JSON data into ListView
                     * */
                    ListAdapter adapter =
                            new ArrayAdapter<String>(MainActivity.this, R.layout.cuisine_type,
                                    R.id.cuisineType, cuisineType);
                    // updating listview
                    cuisineTypeList.setAdapter(adapter);
                }
            });
        }
    }

    private class LoadCuisines extends AsyncTask<String, String, String> {
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(MainActivity.this);
            pDialog.setMessage("Loading products. Please wait...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(false);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            List<NameValuePair> params = new ArrayList<NameValuePair>();
            // getting JSON string from URL
            JSONObject json = jParser.makeHttpRequest(url_all_products, "GET", params);

            // Check your log cat for JSON reponse
            Log.d("All Products: ", json.toString());

            try {
                int hasCuisine = typeMap.get(choiceType);

                if (hasCuisine == 1) {
                    StringBuilder s = new StringBuilder();
                    s.append("cuisines_of_").append(choiceType);
                    cuisines = json.getJSONArray(s.toString());

                    for (int j = 0; j < cuisines.length(); j++) {
                        JSONObject a = cuisines.getJSONObject(j);
                        String name = a.getString(TAG_NAME);
                        String price = a.getString(TAG_PRICE);

                        HashMap<String, String> map = new HashMap<String, String>();
                        map.put(TAG_NAME, name);
                        map.put(TAG_PRICE, price);

                        //cuisine.add(map);

                        s = new StringBuilder();
                        s.append(url_intros).append(a.getString(TAG_INTRO));
                        try {
                            URL url = new URL(s.toString());
                            BufferedReader in = new BufferedReader(new InputStreamReader(url.openStream()));
                            StringBuilder intro = new StringBuilder();
                            String line;
                            while ((line = in.readLine()) != null) {
                                intro.append(line + "\n");
                            }
                            in.close();
                            map.put(TAG_INTRO, intro.toString());

                        } catch (MalformedURLException e) {
                            e.printStackTrace();
                        } catch (IOException e) {
                            e.printStackTrace();
                        }

                        cuisine.add(map);
                    }
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }

            return null;
        }

        protected void onPostExecute(String file_url) {
            // dismiss the dialog after getting all products
            pDialog.dismiss();
            // updating UI from Background Thread
            runOnUiThread(new Runnable() {
                public void run() {
                    /**
                     * Updating parsed JSON data into ListView
                     * */
                    ListAdapter adapter = new SimpleAdapter(
                            MainActivity.this, cuisine,
                            R.layout.cuisine, new String[]{TAG_NAME,
                            TAG_PRICE,TAG_INTRO},
                            new int[]{R.id.cuisineName, R.id.cuisinePrice,R.id.cuisineDescription});
                    // updating listview
                    setListAdapter(adapter);
                }
            });
        }
    }
}
