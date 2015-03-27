package com.emenu.zhenw.emenucustomersapp;

import android.app.ListActivity;
import android.app.ProgressDialog;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.http.AndroidHttpClient;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.TextView;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.NameValuePair;
import org.apache.http.client.methods.HttpGet;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;


public class MainActivity extends ListActivity {
    private ProgressDialog pDialog;
    JSONParser jParser = new JSONParser();
    ArrayList<String> cuisineType;
    private static String url_all_products =
            "http://192.168.1.253/androidphp/Android_Get_CuisineType_v2.php?systemLanguage=English";
    private static String url_images = "http://192.168.1.253/sources/cuisines/photos/";
    private static String url_intros = "http://98.157.156.155:8080/sources/cuisines/intros/";
    private static final String TAG_SUCCESS = "success";
    private static final String TAG_HASCUISINE = "hasCuisine";
    private static final String TAG_CUISINETYPES = "cuisineTypes";
    private static final String TAG_TYPE_ID = "typeID";
    private static final String TAG_TYPE = "type";
    private static final String TAG_NAME = "name";
    private static final String TAG_PRICE = "price";
    private static final String TAG_IMAGE = "image";
    private static final String TAG_INTRO = "intro";
    private String choiceType;
    private ListView cuisineTypeList;
    private HashMap<String, Integer> typeMap;
    private HashMap<String, String> typeIDMap;

    ArrayList<MyItem> item;

    JSONArray types = null;
    JSONArray cuisines = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        cuisineTypeList = (ListView) findViewById(R.id.cuisineTypeList);
        cuisineType = new ArrayList<String>();
        typeMap = new HashMap<String, Integer>();
        typeIDMap = new HashMap<String, String>();
        item = new ArrayList<MyItem>();

        new LoadCuisineTypes().execute();

        cuisineTypeList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                choiceType = ((TextView) view.findViewById(R.id.cuisineType)).getText().toString();
                item = new ArrayList<MyItem>();
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
                        String typeID = c.getString(TAG_TYPE_ID);
                        String type = c.getString(TAG_TYPE);
                        Log.d("TAG", type);
                        int hasCuisine = c.getInt(TAG_HASCUISINE);
                        typeMap.put(type, hasCuisine);
                        typeIDMap.put(type, typeID);

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
            MyItem tmpItem = new MyItem();
            List<NameValuePair> params = new ArrayList<NameValuePair>();
            // getting JSON string from URL
            JSONObject json = jParser.makeHttpRequest(url_all_products, "GET", params);

            // Check your log cat for JSON reponse
            Log.d("All Products: ", json.toString());

            try {
                int hasCuisine = typeMap.get(choiceType);

                if (hasCuisine == 1) {
                    cuisines = json.getJSONArray(typeIDMap.get(choiceType));

                    for (int j = 0; j < cuisines.length(); j++) {
                        JSONObject a = cuisines.getJSONObject(j);
                        tmpItem.name = a.getString(TAG_NAME);
                        tmpItem.price = a.getString(TAG_PRICE);
                        tmpItem.intro = a.getString(TAG_INTRO);

                        StringBuilder s = new StringBuilder();
                        s.append(url_images).append(a.getString(TAG_IMAGE));
                        tmpItem.image = downloadBitmap(s.toString());

                        item.add(tmpItem);
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
                    ListAdapter mAdapter = new CuisineAdapter(MainActivity.this, R.layout.cuisine, R.id.cuisineName, item);
                    // updating listview
                    setListAdapter(mAdapter);
                }

            });
        }
    }

    public class MyItem {
        public String name;
        public String price;
        public String intro;
        public Bitmap image;
    }

    public Bitmap downloadBitmap(String url) {
        final AndroidHttpClient client = AndroidHttpClient.newInstance("Android");
        final HttpGet getRequest = new HttpGet(url);
        try {
            HttpResponse response = client.execute(getRequest);
            final int statusCode = response.getStatusLine().getStatusCode();
            if (statusCode != HttpStatus.SC_OK) {
                Log.w("ImageDownloader", "Error " + statusCode
                        + " while retrieving bitmap from " + url);
                return null;
            }

            final HttpEntity entity = response.getEntity();
            if (entity != null) {
                InputStream inputStream = null;
                try {
                    inputStream = entity.getContent();
                    final Bitmap bitmap = BitmapFactory.decodeStream(inputStream);
                    return bitmap;
                } finally {
                    if (inputStream != null) {
                        inputStream.close();
                    }
                    entity.consumeContent();
                }
            }
        } catch (Exception e) {
            // Could provide a more explicit error message for IOException or
            // IllegalStateException
            getRequest.abort();
            Log.w("ImageDownloader", "Error while retrieving bitmap from " + url);
        } finally {
            if (client != null) {
                client.close();
            }
        }
        return null;
    }
}
