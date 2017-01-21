<%@ WebHandler Language="C#" Class="imageManager" %>
/**
 * Created by visual studio2010
 * User: xuheng
 * Date: 12-3-7
 * Time: ����16:29
 * To change this template use File | Settings | File Templates.
 */
using System;
using System.Web;
using System.IO;
using System.Text.RegularExpressions;

public class imageManager : IHttpHandler
{

    public void ProcessRequest(HttpContext context)
    {
        context.Response.ContentType = "text/plain";

        string path = context.Server.MapPath("upload/");                  //���ʹ������ͼ��ַ������������ʱ���ܻ�������ص���ʱ
        string[] filetype = { ".gif", ".png", ".jpg", ".jpeg", ".bmp" };                //�ļ�������ʽ

        string action = context.Server.HtmlEncode(context.Request["action"]);

        if (action == "get")
        {
            String str = String.Empty;
            DirectoryInfo info = new DirectoryInfo(path);

            //Ŀ¼��֤
            if (info.Exists)
            {
                DirectoryInfo[] infoArr = info.GetDirectories();
                foreach (DirectoryInfo tmpInfo in infoArr)
                {
                        foreach (FileInfo fi in tmpInfo.GetFiles())
                        {
                            if (Array.IndexOf(filetype, fi.Extension) != -1)
                            {
                                str += "upload/" + tmpInfo.Name + "/" + fi.Name + "ue_separate_ue";
                            }
                        }
                }
            }
            context.Response.Write(str);
        }
    }


    public bool IsReusable
    {
        get
        {
            return false;
        }
    }

}